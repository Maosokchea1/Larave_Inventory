<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // 3 permissions
        $viewPerm   = Permission::create(['name' => 'view_products', 'guard_name' => 'web']);
        $editPerm   = Permission::create(['name' => 'edit_products', 'guard_name' => 'web']);
        $deletePerm = Permission::create(['name' => 'delete_products', 'guard_name' => 'web']);

        // 3 roles
        $admin = Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        $admin->permissions()->attach([$viewPerm->id, $editPerm->id, $deletePerm->id]);

        $editor = Role::create(['name' => 'Editor', 'guard_name' => 'web']);
        $editor->permissions()->attach([$viewPerm->id, $editPerm->id]);

        $viewer = Role::create(['name' => 'Viewer', 'guard_name' => 'web']);
        $viewer->permissions()->attach([$viewPerm->id]);
    }
}