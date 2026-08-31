<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBedTypesTable extends Migration
{
    public function up()
    {
        Schema::create('bed_types', function (Blueprint $table) {
            $table->id();

            $table->string('name',100)->unique();
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bed_types');
    }
}