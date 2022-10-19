<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // add super user
        User::insert(
            ["name" => "Super Admin", "email" => "super_admin@gmail.com", "password" => Hash::make("12345678")]
        );

        // roles array
        $roles = Role::select("name")->whereNot("name", "super_admin")->get()->toArray();


        // dummy Data
        for ($i = 0; $i < 10; $i++) {
            $user = new User;
            $user->password = Hash::make("12345678");
            $k = array_rand($roles);
            $v = $roles[$k];
            $user->syncRoles($v);
            $user->name = implode(" ", $v) . rand(1, 100);
            $user->email = $user->name . "@" . Str::random(3) . ".com";
            $user->save();
        }
        $user = User::where("name", "Super Admin")->first();
        $user->syncRoles('super_admin');
    }
}
