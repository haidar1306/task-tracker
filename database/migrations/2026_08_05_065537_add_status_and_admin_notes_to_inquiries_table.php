<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusAndAdminNotesToInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('inquiries', function (Blueprint $table) {
        $table->string('status')->default('Pending')->after('message');
        $table->text('admin_notes')->nullable()->after('status');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
   public function down()
{
    Schema::table('inquiries', function (Blueprint $table) {
        $table->dropColumn(['status', 'admin_notes']);
    });
}
}
