<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
{
    Schema::create('general_settings', function (Blueprint $table) {

        $table->id();

        $table->string('website_name')->nullable();

        $table->string('website_logo')->nullable();

        $table->string('favicon')->nullable();

        $table->string('email')->nullable();

        $table->string('phone')->nullable();

        $table->text('address')->nullable();

        $table->string('copyright')->nullable();

        $table->boolean('status')->default(true);

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
        Schema::dropIfExists('general_settings');
    }
}
