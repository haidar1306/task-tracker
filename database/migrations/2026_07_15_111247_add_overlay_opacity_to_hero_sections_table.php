<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOverlayOpacityToHeroSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
{
    Schema::table('hero_sections', function (Blueprint $table) {
        $table->integer('overlay_opacity')->default(40)->after('background_image');
    });
}

public function down()
{
    Schema::table('hero_sections', function (Blueprint $table) {
        $table->dropColumn('overlay_opacity');
    });
}
}
