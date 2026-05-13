<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditObserver
{
    public function created(Model $model): void
    {
        $this->log('created', $model, null, $model->getAttributes());
    }

    public function updated(Model $model): void
    {
        $this->log('updated', $model, $model->getOriginal(), $model->getChanges());
    }

    public function deleted(Model $model): void
    {
        $this->log('deleted', $model, $model->getOriginal(), null);
    }

    protected function log(string $event, Model $model, ?array $old, ?array $new): void
    {
        // Skip audit during artisan/seed operations.
        if (app()->runningInConsole()) {
            return;
        }

        try {
            AuditLog::create([
                'user_id'        => Auth::id(),
                'branch_id'      => session('admin.branch_id'),
                'event'          => $event . ':' . class_basename($model),
                'auditable_type' => get_class($model),
                'auditable_id'   => $model->getKey(),
                'old_values'     => $this->scrub($old),
                'new_values'     => $this->scrub($new),
                'ip_address'     => Request::ip(),
                'user_agent'     => substr((string) Request::userAgent(), 0, 255),
                'url'            => substr((string) Request::fullUrl(), 0, 255),
                'method'         => Request::method(),
            ]);
        } catch (\Throwable $e) {
            // Audit failures must never break the main flow.
            \Illuminate\Support\Facades\Log::warning('AuditObserver failed: ' . $e->getMessage());
        }
    }

    protected function scrub(?array $values): ?array
    {
        if (! $values) {
            return $values;
        }
        $masked = ['password', 'remember_token', 'rfid_uid', 'barcode_value'];
        foreach ($masked as $k) {
            if (array_key_exists($k, $values)) {
                $values[$k] = '***';
            }
        }
        return $values;
    }
}
