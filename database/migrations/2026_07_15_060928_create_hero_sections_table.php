<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeroSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('hero_sections', function (Blueprint $table) {
    $table->id();
    $table->string('badge')->nullable();
    $table->string('heading');
    $table->text('description')->nullable();
    $table->string('primary_button_text')->nullable();
    $table->string('primary_button_link')->nullable();
    $table->string('secondary_button_text')->nullable();
    $table->string('secondary_button_link')->nullable();
    $table->string('hero_image')->nullable();
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
        Schema::dropIfExists('hero_sections');
    }
}
