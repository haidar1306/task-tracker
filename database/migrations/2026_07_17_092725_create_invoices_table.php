<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {

            $table->id();

            $table->string('invoice_no')->unique();

            $table->unique('booking_id');

            $table->decimal('room_charge', 10, 2)->default(0);

            $table->decimal('extra_charge', 10, 2)->default(0);

            $table->decimal('tax', 10, 2)->default(0);

            $table->decimal('discount', 10, 2)->default(0);

            $table->decimal('total_amount', 10, 2)->default(0);

            $table->string('payment_method')
                ->nullable();

            $table->string('payment_status')
                ->default('Pending');

            $table->decimal('paid_amount', 10, 2)
                ->default(0);

            $table->text('remarks')
                ->nullable();

            $table->boolean('status')
                ->default(true);

            $table->timestamps();


            $table->foreign('booking_id')
                ->references('id')
                ->on('bookings')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
