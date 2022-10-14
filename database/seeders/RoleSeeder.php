<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([["name" => "super_admin", "guard_name" => "web"], ["name" => "admin", "guard_name" => "web"], ["name" => "user", "guard_name" => "web"]]);
        $user = User::where("name", "Super Admin")->first();
        $user->syncRoles('super_admin');
    }
}
