<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceIdToPaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {

            $table->foreignId('invoice_id')
                ->after('booking_id')
                ->nullable()
                ->constrained('invoices')
                ->cascadeOnDelete();

        });
    }


    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {

            $table->dropForeign(['invoice_id']);
            $table->dropColumn('invoice_id');

        });
    }
}