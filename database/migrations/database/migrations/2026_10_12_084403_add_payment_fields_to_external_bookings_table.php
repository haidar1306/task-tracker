<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('external_bookings', function (Blueprint $table) {
            $table->string('payment_status')->default('unpaid');
            $table->string('booking_reference')->nullable();
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->timestamp('paid_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('external_bookings', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'booking_reference',
                'razorpay_order_id',
                'razorpay_payment_id',
                'payment_method',
                'paid_at',
            ]);
        });
    }
};
