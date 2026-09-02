<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ListTables extends Command
{
    protected $signature = 'db:list-tables';
    protected $description = 'List all tables in the public schema';

    public function handle()
    {
        $tables = DB::select("select tablename from pg_tables where schemaname='public'");
        foreach ($tables as $t) {
            $this->info($t->tablename);
        }
    }
}
