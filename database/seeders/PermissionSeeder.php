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
        $admin_permissions = [
            "add_user",
            "edit_user",
            "delete_user",
            "show_user",

            "add_role",
            "edit_role",
            "delete_role",
            "show_role",

            "add_permission",
            "edit_permission",
            "delete_permission",
            "show_permission",

            "add_product",
            "edit_product",
            "delete_product",
            "show_product"

        ];
        $manager_permissions = [
            "add_product",
            "edit_product",
            "delete_product",
            "show_product"
        ];
        $user_permissions = [
            "show_product"
        ];
        foreach ($admin_permissions as $p) {
            $role = Permission::insert(["name" => $p, "guard_name" => "web"]);
        }
        $role = Role::findByName('admin');
        $role->syncPermissions($admin_permissions);

        $role = Role::findByName('manager');
        $role->syncPermissions($manager_permissions);

        $role = Role::findByName('user');
        $role->syncPermissions($user_permissions);
    }
}
