<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProviderColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
{
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'provider')) {
            $table->string('provider')->nullable();
        }
        if (!Schema::hasColumn('users', 'provider_id')) {
            $table->string('provider_id')->nullable();
        }
        // agar aur columns bhi is migration mein hain, unhe bhi isi tarah wrap karo
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['provider', 'provider_id']);
    });
}
}
