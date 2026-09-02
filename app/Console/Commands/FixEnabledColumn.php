<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixEnabledColumn extends Command
{
    protected $signature = 'db:fix-enabled-column';
    protected $description = 'Ensure all expected columns exist on announcements table';

    public function handle()
    {
        $columns = [
            'enabled' => "ALTER TABLE announcements ADD COLUMN enabled boolean DEFAULT true",
            'area' => "ALTER TABLE announcements ADD COLUMN area varchar(255) NULL",
            'type' => "ALTER TABLE announcements ADD COLUMN type varchar(255) NULL",
            'message' => "ALTER TABLE announcements ADD COLUMN message text NULL",
            'starts_at' => "ALTER TABLE announcements ADD COLUMN starts_at timestamp NULL",
            'ends_at' => "ALTER TABLE announcements ADD COLUMN ends_at timestamp NULL",
        ];

        foreach ($columns as $column => $sql) {
            if (!Schema::hasColumn('announcements', $column)) {
                DB::statement($sql);
                $this->info("$column column added.");
            } else {
                $this->info("$column column already exists.");
            }
        }
    }
}