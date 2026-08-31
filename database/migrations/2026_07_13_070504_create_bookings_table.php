<?php



use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;



class CreateBookingsTable extends Migration

{

    public function up()

    {

        Schema::create('Bookings', function (Blueprint $table) {



            $table->id();



            $table->string('booking_no')->unique();



            $table->foreignId('guest_id')

                  ->constrained('guests')

                  ->cascadeOnDelete();



            $table->foreignId('room_id')

                  ->constrained('rooms')

                  ->cascadeOnDelete();



            $table->date('check_in');



            $table->date('check_out');



            $table->unsignedInteger('adults')->default(1);



            $table->unsignedInteger('children')->default(0);



            $table->decimal('total_amount',10,2)->default(0);



            $table->enum('booking_status',[

                'Pending',

                'Confirmed',

                'Checked In',

                'Checked Out',

                'Cancelled'

            ])->default('Pending');



            $table->enum('payment_status',[

                'Pending',

                'Partial',

                'Paid',

                'Refunded'

            ])->default('Pending');



            $table->text('remarks')->nullable();



            $table->boolean('status')->default(true);



            $table->timestamps();



        });

    }



    public function down()

    {

        Schema::dropIfExists('bookings');

    }

}