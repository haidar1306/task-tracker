<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedByToUsersTable extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'created_by')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('created_by')->default('system');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'created_by')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('created_by');
            });
        }
    }
}