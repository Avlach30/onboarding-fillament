<?php

namespace Database\Seeders;

use App\Enums\Permission as EnumsPermission;
use App\Enums\Role as EnumsRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Bulk create permissions
        Permission::insert(array_map(fn($permission) => ['name' => $permission, 'guard_name' => 'web'], EnumsPermission::getValues()));

        // Create role super admin
        $superAdmin = Role::create(['name' => EnumsRole::SUPER_ADMIN, 'guard_name' => 'web']);

        // Assign all permissions to super admin
        $superAdmin->givePermissionTo(Permission::all());

        // Assign super admin role to the admin user
        $adminEmail = 'admin@mail.com';
        $admin = User::where('email', $adminEmail)->first();

        // Check if the admin user exists, assign the super admin role to the admin user and save it
        if ($admin) {
            $admin->role_id = $superAdmin->id;

            $admin->update();
        }
    }
}
