<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixEnabledColumn extends Command
{
    protected $signature = 'db:fix-enabled-column';
    protected $description = 'Add enabled column to announcements table if missing';

    public function handle()
    {
        if (!Schema::hasColumn('announcements', 'enabled')) {
            DB::statement('ALTER TABLE announcements ADD COLUMN enabled boolean DEFAULT true');
            $this->info('enabled column added.');
        } else {
            $this->info('enabled column already exists.');
        }
    }
}