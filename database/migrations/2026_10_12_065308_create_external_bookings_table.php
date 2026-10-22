<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('external_bookings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->unsignedBigInteger('hotel_id');
    $table->string('hotel_name');
    $table->string('hotel_image', 500)->nullable();
    $table->date('check_in');
    $table->date('check_out');
    $table->unsignedTinyInteger('guests');
    $table->decimal('total_price', 10, 2);
    $table->string('currency', 3)->default('INR');
    $table->string('status')->default('pending');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_bookings');
    }
}
