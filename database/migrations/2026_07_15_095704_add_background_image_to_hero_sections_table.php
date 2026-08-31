<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBackgroundImageToHeroSectionsTable extends Migration
{
    public function up()
    {
        Schema::table('hero_sections', function (Blueprint $table) {
            $table->string('background_image')->nullable()->after('hero_image');
        });
    }

    public function down()
    {
        Schema::table('hero_sections', function (Blueprint $table) {
            $table->dropColumn('background_image');
        });
    }
}