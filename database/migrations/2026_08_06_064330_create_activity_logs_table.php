<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up(): void
{
    Schema::create('activity_logs', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
              ->nullable()
              ->constrained()
              ->nullOnDelete();

        $table->string('module');        // Booking, Payment, Inquiry
        $table->string('action');        // Created, Confirmed, Paid
        $table->text('description');

        $table->ipAddress('ip_address')->nullable();

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
        Schema::dropIfExists('activity_logs');
    }
}
