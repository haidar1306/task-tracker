<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tableName = 'coupons';

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            if (! Schema::hasColumn($tableName, 'discount_type')) {
                $table->string('discount_type')->default('fixed');
            }

            if (! Schema::hasColumn($tableName, 'discount_value')) {
                $table->decimal('discount_value', 10, 2)->default(0);
            }

            if (! Schema::hasColumn($tableName, 'minimum_amount')) {
                $table->decimal('minimum_amount', 10, 2)->default(0);
            }

            if (! Schema::hasColumn($tableName, 'maximum_discount')) {
                $table->decimal('maximum_discount', 10, 2)->nullable();
            }

            if (! Schema::hasColumn($tableName, 'starts_at')) {
                $table->dateTime('starts_at')->nullable();
            }

            if (! Schema::hasColumn($tableName, 'expires_at')) {
                $table->dateTime('expires_at')->nullable();
            }

            if (! Schema::hasColumn($tableName, 'usage_limit')) {
                $table->unsignedInteger('usage_limit')->nullable();
            }

            if (! Schema::hasColumn($tableName, 'used_count')) {
                $table->unsignedInteger('used_count')->default(0);
            }

            if (! Schema::hasColumn($tableName, 'status')) {
                $table->boolean('status')->default(true);
            }

            if (! Schema::hasColumn($tableName, 'description')) {
                $table->text('description')->nullable();
            }
        });
    }

    public function down(): void
    {
        // Keep deployed coupon data when rolling back this compatibility migration.
    }
};
