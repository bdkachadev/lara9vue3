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

            "show_dashboard",

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
            "show_product",

            "add_order",
            "edit_order",
            "delete_order",
            "show_order",
            "cancel_order",

            "show_taxonomy",
            "edit_taxonomy",
            "delete_taxonomy",
            "show_taxonomy",

            "add_attribute",
            "edit_attribute",
            "delete_attribute",
            "show_attribute",

            "add_category",
            "edit_category",
            "delete_category",
            "show_category",

            "add_brand",
            "edit_brand",
            "delete_brand",
            "show_brand",

            "add_tag",
            "edit_tag",
            "delete_tag",
            "show_tag",

            "show_taxonomy_attribute",
            "edit_taxonomy__attribute",
            "delete_taxonomy__attribute",
            "show_taxonomy__attribute",

            "edit_attribute_value",
            "delete_attribute_value",
            "show_attribute_value",
            "add_attribute_value",

        ];
        $manager_permissions = [
            "show_dashboard",

            "add_product",
            "edit_product",
            "delete_product",
            "show_product",

            "add_order",
            "edit_order",
            "delete_order",
            "show_order",
            "cancel_order",

            "show_taxonomy",
            "edit_taxonomy",
            "delete_taxonomy",
            "show_taxonomy",

            "add_attribute",
            "edit_attribute",
            "delete_attribute",
            "show_attribute",

            "add_category",
            "edit_category",
            "delete_category",
            "show_category",

            "add_brand",
            "edit_brand",
            "delete_brand",
            "show_brand",

            "add_tag",
            "edit_tag",
            "delete_tag",
            "show_tag",

            "show_taxonomy_attribute",
            "edit_taxonomy__attribute",
            "delete_taxonomy__attribute",
            "show_taxonomy__attribute",

            "edit_attribute_value",
            "delete_attribute_value",
            "show_attribute_value",
            "add_attribute_value",

        ];
        $user_permissions = [
            "show_home", "show_order", "cancel_order", "show_cart", "add_cart", "edit_cart", "delete_cart", "buy_now"
        ];
        foreach (array_merge($admin_permissions, $manager_permissions, $user_permissions) as $p) {
            $role =  Permission::firstOrNew(["name" => $p]);
            $role->name = $p;
            $role->guard_name = "web";
            $role->save();
        }
        // $Permission = Permission::firstOrNew(["name" => "show_home"]);
        // $Permission->name = "show_home";
        // $Permission->guard_name = "web";
        // $Permission->save();

        $role = Role::findByName('admin');
        $role->syncPermissions($admin_permissions);

        $role = Role::findByName('manager');
        $role->syncPermissions($manager_permissions);

        $role = Role::findByName('user');
        $role->syncPermissions($user_permissions);
    }
}
