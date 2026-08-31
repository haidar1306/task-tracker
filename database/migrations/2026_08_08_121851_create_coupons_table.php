<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();

            $table->enum('discount_type', ['percentage', 'fixed']);

            $table->decimal('discount_value', 10, 2);

            $table->decimal('minimum_amount', 10, 2)->default(0);

            $table->decimal('maximum_discount', 10, 2)->nullable();

            $table->dateTime('starts_at')->nullable();

            $table->dateTime('expires_at')->nullable();

            $table->unsignedInteger('usage_limit')->nullable();

            $table->unsignedInteger('used_count')->default(0);

            $table->boolean('status')->default(true);

            $table->text('description')->nullable();

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
        Schema::dropIfExists('coupons');
    }
}