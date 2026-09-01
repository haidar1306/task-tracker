<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToBeLoggedOutToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up(): void
{
    if (!Schema::hasColumn('users', 'to_be_logged_out')) {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('to_be_logged_out')->default(false);
        });
    }
}

public function down(): void
{
    if (Schema::hasColumn('users', 'to_be_logged_out')) {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('to_be_logged_out');
        });
    }
}
}
