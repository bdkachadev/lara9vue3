<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'add_user',
            'edit_user',
            'delete_user',

            'add_role',
            'edit_role',
            'delete_role',

            'add_permission',
            'edit_permission',
            'delete_permission',

        ];
        foreach ($permissions as $p) {
            $role = Permission::insert(["name" => $p, "guard_name" => "web"]);
        }
        $role = Role::findByName('super_admin');
        $role->syncPermissions($permissions);
    }
}
