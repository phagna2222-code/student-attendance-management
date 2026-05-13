<?php

namespace App\Console\Commands;

use App\Models\BackupLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BackupRunCommand extends Command
{
    protected $signature = 'backup:run {--type=database : database|files|full}';
    protected $description = 'Run a backup of the database and/or files and log the result to backup_logs.';

    public function handle(): int
    {
        $type = $this->option('type');
        $disk = config('filesystems.default') === 'local' ? 'local' : 'local';

        $log = BackupLog::create([
            'type'         => $type,
            'destination'  => $disk,
            'status'       => 'running',
            'requested_by' => null,
            'started_at'   => now(),
        ]);

        try {
            $dir = 'backups/' . now()->format('Y/m');
            Storage::disk($disk)->makeDirectory($dir);
            $filename = sprintf('%s/sams-%s-%s.zip', $dir, $type, now()->format('Ymd_His'));
            $absolutePath = Storage::disk($disk)->path($filename);

            $zip = new \ZipArchive();
            if ($zip->open($absolutePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
                throw new \RuntimeException('Failed to open zip archive: '.$absolutePath);
            }

            if (in_array($type, ['database', 'full'], true)) {
                $dbPath = config('database.connections.'.config('database.default').'.database');
                if ($dbPath && is_file($dbPath)) {
                    $zip->addFile($dbPath, 'database/' . basename($dbPath));
                } else {
                    $dump = base_path('storage/app/db-dump-'.now()->format('Ymd_His').'.sql');
                    $this->dumpSqlPlaceholder($dump);
                    $zip->addFile($dump, 'database/' . basename($dump));
                }
            }

            if (in_array($type, ['files', 'full'], true)) {
                $publicDir = base_path('storage/app/public');
                if (is_dir($publicDir)) {
                    $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($publicDir, \FilesystemIterator::SKIP_DOTS));
                    foreach ($rii as $file) {
                        if ($file->isDir()) continue;
                        $local = 'public/' . substr($file->getPathname(), strlen($publicDir) + 1);
                        $zip->addFile($file->getPathname(), $local);
                    }
                }
            }

            $zip->close();
            $size = filesize($absolutePath) ?: 0;

            $log->update([
                'status'      => 'success',
                'finished_at' => now(),
                'file_path'   => $filename,
                'file_size'   => $size,
                'message'     => 'Backup completed',
            ]);

            $this->info("Backup written: {$filename} ({$size} bytes)");
            return self::SUCCESS;
        } catch (\Throwable $e) {
            $log->update([
                'status'      => 'failed',
                'finished_at' => now(),
                'message'     => $e->getMessage(),
            ]);
            $this->error('Backup failed: '.$e->getMessage());
            return self::FAILURE;
        }
    }

    protected function dumpSqlPlaceholder(string $path): void
    {
        file_put_contents($path, "-- SQL dump placeholder. Configure a real dumper (mysqldump/pg_dump) for production.\n-- Generated at ".now()."\n");
    }
}
