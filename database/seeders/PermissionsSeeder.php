<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list clients']);
        Permission::create(['name' => 'view clients']);
        Permission::create(['name' => 'create clients']);
        Permission::create(['name' => 'update clients']);
        Permission::create(['name' => 'delete clients']);

        Permission::create(['name' => 'list events']);
        Permission::create(['name' => 'view events']);
        Permission::create(['name' => 'create events']);
        Permission::create(['name' => 'update events']);
        Permission::create(['name' => 'delete events']);

        Permission::create(['name' => 'list fields']);
        Permission::create(['name' => 'view fields']);
        Permission::create(['name' => 'create fields']);
        Permission::create(['name' => 'update fields']);
        Permission::create(['name' => 'delete fields']);

        Permission::create(['name' => 'list products']);
        Permission::create(['name' => 'view products']);
        Permission::create(['name' => 'create products']);
        Permission::create(['name' => 'update products']);
        Permission::create(['name' => 'delete products']);

        Permission::create(['name' => 'list productdescriptions']);
        Permission::create(['name' => 'view productdescriptions']);
        Permission::create(['name' => 'create productdescriptions']);
        Permission::create(['name' => 'update productdescriptions']);
        Permission::create(['name' => 'delete productdescriptions']);

        Permission::create(['name' => 'list statuses']);
        Permission::create(['name' => 'view statuses']);
        Permission::create(['name' => 'create statuses']);
        Permission::create(['name' => 'update statuses']);
        Permission::create(['name' => 'delete statuses']);

        Permission::create(['name' => 'list works']);
        Permission::create(['name' => 'view works']);
        Permission::create(['name' => 'create works']);
        Permission::create(['name' => 'update works']);
        Permission::create(['name' => 'delete works']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
