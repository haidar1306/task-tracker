<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueTransactionToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('payments', function (Blueprint $table) {
        $table->unique('transaction_id');
    });
}

public function down()
{
    Schema::table('payments', function (Blueprint $table) {
        $table->dropUnique(['transaction_id']);
    });
}
}
