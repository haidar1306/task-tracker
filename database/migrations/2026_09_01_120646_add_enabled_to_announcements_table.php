<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnabledToAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up(): void
{
    if (!Schema::hasColumn('announcements', 'enabled')) {
        Schema::table('announcements', function (Blueprint $table) {
            $table->boolean('enabled')->default(true);
        });
    }
}

public function down(): void
{
    if (Schema::hasColumn('announcements', 'enabled')) {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn('enabled');
        });
    }
}
}
