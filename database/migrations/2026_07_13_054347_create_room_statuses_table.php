<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('room_statuses', function (Blueprint $table) {

            $table->id();

            $table->string('name',100)->unique();
            $table->string('color',30)->default('success');
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('room_statuses');
    }
}