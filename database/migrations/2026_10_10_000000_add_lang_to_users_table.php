<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLangToUsersTable extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'lang')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('lang')->default('en');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'lang')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('lang');
            });
        }
    }
}