<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToRoomTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::table('room_types', function (Blueprint $table) {
        $table->string('image')->nullable()->after('description');
    });
}

public function down()
{
    Schema::table('room_types', function (Blueprint $table) {
        $table->dropColumn('image');
    });
}
}
