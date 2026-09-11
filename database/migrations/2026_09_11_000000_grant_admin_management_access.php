<?php

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $adminRole = Role::firstOrCreate(
            ['name' => config('boilerplate.access.role.admin')],
            ['type' => User::TYPE_ADMIN]
        );

        $adminRole->syncPermissions(Permission::query()->get());

        User::where('type', User::TYPE_ADMIN)
            ->get()
            ->each(fn (User $user) => $user->assignRole($adminRole));
    }

    public function down(): void
    {
        // Access is intentionally retained when rolling back this data migration.
    }
};