<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCouponRedemptionToInvoicesTable extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('invoices', 'coupon_id')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->foreignId('coupon_id')->nullable()->after('discount')
                    ->constrained('coupons')->nullOnDelete();
            });
        }

        if (!Schema::hasColumn('invoices', 'coupon_discount')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->decimal('coupon_discount', 10, 2)->default(0)->after('coupon_id');
            });
        }

        if (!Schema::hasColumn('invoices', 'coupon_redeemed_at')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->timestamp('coupon_redeemed_at')->nullable()->after('coupon_discount');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('invoices', 'coupon_redeemed_at')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->dropColumn('coupon_redeemed_at');
            });
        }

        if (Schema::hasColumn('invoices', 'coupon_discount')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->dropColumn('coupon_discount');
            });
        }

        if (Schema::hasColumn('invoices', 'coupon_id')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->dropForeign(['coupon_id']);
                $table->dropColumn('coupon_id');
            });
        }
    }
}