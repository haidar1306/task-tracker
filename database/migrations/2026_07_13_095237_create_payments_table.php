<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            $table->date('payment_date');

            $table->decimal('amount', 10, 2);

            $table->enum('payment_method', [
                'Cash',
                'Card',
                'UPI',
                'Bank Transfer',
                'Razorpay'
            ]);

            $table->string('transaction_id')->nullable();

            $table->enum('payment_status', [
                'Pending',
                'Paid',
                'Failed',
                'Refunded'
            ])->default('Pending');

            $table->text('remarks')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}