<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBackgroundColorToHeroSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hero_sections', function (Blueprint $table) {
            $table->string('background_color')->nullable()->after('background_image');
        });
    }

    public function down()
    {
        Schema::table('hero_sections', function (Blueprint $table) {
            $table->dropColumn('background_color');
        });
    }
}
