<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\NotificationLog;
use Illuminate\Database\Seeder;

class NotificationLogSeeder extends Seeder
{
    public function run(): void
    {
        Notification::orderBy('id')->get()->each(function (Notification $n) {
            NotificationLog::updateOrCreate(
                ['notification_id' => $n->id, 'provider' => 'twilio'],
                [
                    'provider_message_id' => 'SM'.str_pad((string) $n->id, 12, '0', STR_PAD_LEFT),
                    'request_payload'     => ['to' => $n->recipient_contact, 'body' => $n->message],
                    'response_payload'    => ['sid' => 'SM'.$n->id, 'status' => 'delivered'],
                    'status'              => 'success',
                    'error_message'       => null,
                ]
            );
        });
    }
}
