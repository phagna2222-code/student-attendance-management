<?php

namespace Database\Seeders;

use App\Models\BackupLog;
use App\Models\User;
use Illuminate\Database\Seeder;

class BackupLogSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();

        $rows = [
            ['type' => 'database', 'destination' => 'local', 'status' => 'success',  'file_path' => 'backups/db-2025-09-30.sql.gz', 'file_size' => 2_456_789, 'message' => 'Daily database backup OK'],
            ['type' => 'database', 'destination' => 'cloud', 'status' => 'success',  'file_path' => 'backups/db-2025-10-01.sql.gz', 'file_size' => 2_512_345, 'message' => 'Uploaded to S3'],
            ['type' => 'files',    'destination' => 'local', 'status' => 'failed',   'file_path' => null,                            'file_size' => null,      'message' => 'Disk full'],
            ['type' => 'full',     'destination' => 'cloud', 'status' => 'running',  'file_path' => null,                            'file_size' => null,      'message' => 'In progress'],
        ];

        foreach ($rows as $i => $r) {
            BackupLog::create($r + [
                'requested_by' => optional($admin)->id,
                'started_at'   => now()->subDays($i)->setTime(2, 0),
                'finished_at'  => $r['status'] === 'success' ? now()->subDays($i)->setTime(2, 5) : null,
            ]);
        }
    }
}
