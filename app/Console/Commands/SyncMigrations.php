<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SyncMigrations extends Command
{
    protected $signature = 'db:sync-migrations';
    protected $description = 'Reconcile migrations table with actual DB schema, then run truly pending migrations';

    public function handle()
    {
        if (!Schema::hasTable('migrations')) {
            $this->call('migrate:install');
        }

        $ran = DB::table('migrations')->pluck('migration')->toArray();
        $batch = (int) DB::table('migrations')->max('batch');
        $batch++;

        $files = glob(database_path('migrations') . '/*.php');
        sort($files);

        foreach ($files as $file) {
            $name = basename($file, '.php');
            if (in_array($name, $ran)) {
                continue;
            }

            if (preg_match('/create_(.+)_table$/', $name, $m) && Schema::hasTable($m[1])) {
                DB::table('migrations')->insert(['migration' => $name, 'batch' => $batch]);
                $this->info("Marked done (table exists): $name");
                continue;
            }

            try {
                $this->call('migrate', [
                    '--path' => 'database/migrations/' . basename($file),
                    '--force' => true,
                ]);
                $this->info("Ran: $name");
            } catch (\Throwable $e) {
                if (str_contains($e->getMessage(), 'already exists')) {
                    DB::table('migrations')->insert(['migration' => $name, 'batch' => $batch]);
                    $this->warn("Marked done (already existed): $name");
                } else {
                    $this->error("Skipped (error): $name - " . $e->getMessage());
                }
            }
        }

        $this->info('Sync complete.');
    }
}