<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestsTable extends Migration
{
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {

            $table->id();

            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone',20);
            $table->enum('gender',['Male','Female','Other'])->nullable();
            $table->date('dob')->nullable();

            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();

            $table->string('id_proof_type')->nullable();
            $table->string('id_proof_number')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('guests');
    }
}