<?php

namespace App\Services\Notifications;

use App\Models\Notification;
use App\Models\NotificationLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Multi-channel notification dispatcher.
 * Supported: email (SMTP via Mail), telegram (bot API), portal (no-op), push/sms (stubbed).
 * Configure via env: TELEGRAM_BOT_TOKEN, MAIL_FROM_ADDRESS, etc.
 */
class NotificationDispatcher
{
    public function send(Notification $notification): bool
    {
        $ok = match ($notification->channel) {
            'email'    => $this->sendEmail($notification),
            'telegram' => $this->sendTelegram($notification),
            'sms'      => $this->sendSms($notification),
            'portal'   => $this->sendPortal($notification),
            'push'     => $this->sendPush($notification),
            default    => false,
        };
        return $ok;
    }

    protected function sendEmail(Notification $n): bool
    {
        if (! $n->recipient_contact || ! filter_var($n->recipient_contact, FILTER_VALIDATE_EMAIL)) {
            return $this->markFailed($n, 'email', 'Invalid recipient email');
        }
        try {
            Mail::raw($n->message, function ($m) use ($n) {
                $m->to($n->recipient_contact)
                  ->subject($n->subject ?? '(no subject)');
            });
            return $this->markSent($n, 'mail', null, ['to' => $n->recipient_contact]);
        } catch (\Throwable $e) {
            return $this->markFailed($n, 'mail', $e->getMessage());
        }
    }

    protected function sendTelegram(Notification $n): bool
    {
        $token = config('services.telegram.bot_token') ?: env('TELEGRAM_BOT_TOKEN');
        if (! $token) {
            return $this->markFailed($n, 'telegram', 'TELEGRAM_BOT_TOKEN not set');
        }
        if (! $n->recipient_contact) {
            return $this->markFailed($n, 'telegram', 'Missing chat_id');
        }
        try {
            $body = ($n->subject ? '<b>'.htmlspecialchars($n->subject).'</b>'."\n\n" : '')
                  . htmlspecialchars((string) $n->message);
            $res = Http::asJson()->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id'    => $n->recipient_contact,
                'text'       => $body,
                'parse_mode' => 'HTML',
            ]);
            if ($res->successful()) {
                $providerId = (string) data_get($res->json(), 'result.message_id');
                return $this->markSent($n, 'telegram', $providerId, $res->json());
            }
            return $this->markFailed($n, 'telegram', 'HTTP '.$res->status().': '.$res->body());
        } catch (\Throwable $e) {
            return $this->markFailed($n, 'telegram', $e->getMessage());
        }
    }

    protected function sendSms(Notification $n): bool
    {
        // Stub. Wire to your provider (Twilio, Vonage, Plasgate, etc.).
        Log::info('SMS provider not configured; treating as failed', ['notification_id' => $n->id]);
        return $this->markFailed($n, 'sms', 'SMS provider not configured');
    }

    protected function sendPortal(Notification $n): bool
    {
        // In-app portal notifications: nothing to do — they're already in DB.
        return $this->markSent($n, 'portal');
    }

    protected function sendPush(Notification $n): bool
    {
        Log::info('Push provider not configured; treating as failed', ['notification_id' => $n->id]);
        return $this->markFailed($n, 'push', 'Push provider not configured');
    }

    protected function markSent(Notification $n, string $provider, ?string $providerMessageId = null, $responsePayload = null): bool
    {
        $n->update([
            'status'  => 'sent',
            'sent_at' => now(),
            'failure_reason' => null,
        ]);
        NotificationLog::create([
            'notification_id'      => $n->id,
            'provider'             => $provider,
            'provider_message_id'  => $providerMessageId,
            'request_payload'      => ['channel' => $n->channel, 'to' => $n->recipient_contact],
            'response_payload'     => is_array($responsePayload) ? $responsePayload : null,
            'status'               => 'success',
        ]);
        return true;
    }

    protected function markFailed(Notification $n, string $provider, string $reason): bool
    {
        $n->update([
            'status'         => 'failed',
            'failure_reason' => $reason,
        ]);
        NotificationLog::create([
            'notification_id' => $n->id,
            'provider'        => $provider,
            'status'          => 'failed',
            'error_message'   => $reason,
        ]);
        return false;
    }
}
