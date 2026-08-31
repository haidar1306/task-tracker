<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTextColorToHeroSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
{
    Schema::table('hero_sections', function (Blueprint $table) {
        $table->string('text_color')->default('#ffffff')->after('background_color');
    });
}

public function down()
{
    Schema::table('hero_sections', function (Blueprint $table) {
        $table->dropColumn('text_color');
    });
}
}
