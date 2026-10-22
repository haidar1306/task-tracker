<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HardenBookingsAndGuests extends Migration
{
    public function up()
    {
        // ---- guests: user se link (email par bharosa nahi) ----
        Schema::table('guests', function (Blueprint $table) {
            if (!Schema::hasColumn('guests', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id')->index();
            }
        });

        // ---- bookings: naye columns ----
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'idempotency_key')) {
                $table->string('idempotency_key', 64)->nullable()->unique();
            }
            if (!Schema::hasColumn('bookings', 'nightly_rate')) {
                $table->decimal('nightly_rate', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('bookings', 'expires_at')) {
                $table->timestamp('expires_at')->nullable();
            }
        });

        if (DB::getDriverName() === 'mysql') {
            // enum -> string: Rejected / Expired / No Show jaise status bina alter ke chalenge.
            DB::statement("ALTER TABLE bookings MODIFY booking_status VARCHAR(30) NOT NULL DEFAULT 'Pending'");

            // Purane guests ko email se user ke saath jodo (ek baar).
            try {
                DB::statement('UPDATE guests g INNER JOIN users u ON LOWER(u.email) = LOWER(g.email) SET g.user_id = u.id WHERE g.user_id IS NULL');
            } catch (\Throwable $e) {
                // users table ka naam alag ho to skip
            }

            // Purani bookings ka rate snapshot.
            try {
                DB::statement('UPDATE bookings b INNER JOIN rooms r ON r.id = b.room_id INNER JOIN room_types rt ON rt.id = r.room_type_id SET b.nightly_rate = rt.price WHERE b.nightly_rate IS NULL');
            } catch (\Throwable $e) {
                // room_types ka naam alag ho to skip
            }
        }

        // ---- indexes (availability check tez ho) ----
        try {
            Schema::table('bookings', function (Blueprint $table) {
                $table->index(['room_id', 'check_in', 'check_out'], 'bookings_room_dates_index');
            });
        } catch (\Throwable $e) {
        }

        try {
            Schema::table('bookings', function (Blueprint $table) {
                $table->index('booking_status', 'bookings_status_index');
            });
        } catch (\Throwable $e) {
        }
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            foreach (['idempotency_key', 'nightly_rate', 'expires_at'] as $column) {
                if (Schema::hasColumn('bookings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('guests', function (Blueprint $table) {
            if (Schema::hasColumn('guests', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }
}