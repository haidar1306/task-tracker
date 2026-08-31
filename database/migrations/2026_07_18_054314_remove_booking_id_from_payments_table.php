<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveBookingIdFromPaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {

            $table->dropForeign(['booking_id']);

            $table->dropColumn('booking_id');

        });
    }


    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {

            $table->foreignId('booking_id')
                ->constrained('bookings')
                ->cascadeOnDelete();

        });
    }
}