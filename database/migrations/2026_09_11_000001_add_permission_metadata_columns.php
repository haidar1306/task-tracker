<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tableName = config('permission.table_names.permissions');

        Schema::table($tableName, function (Blueprint $blueprint) use ($tableName) {
            if (! Schema::hasColumn($tableName, 'description')) {
                $blueprint->string('description')->nullable();
            }

            if (! Schema::hasColumn($tableName, 'parent_id')) {
                $blueprint->unsignedBigInteger('parent_id')->nullable();
            }

            if (! Schema::hasColumn($tableName, 'sort')) {
                $blueprint->tinyInteger('sort')->default(1);
            }
        });
    }

    public function down(): void
    {
        $tableName = config('permission.table_names.permissions');

        Schema::table($tableName, function (Blueprint $blueprint) use ($tableName) {
            foreach (['description', 'parent_id', 'sort'] as $column) {
                if (Schema::hasColumn($tableName, $column)) {
                    $blueprint->dropColumn($column);
                }
            }
        });
    }
};
