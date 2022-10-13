<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([["name"=>"Admin","email"=>"admin@gmail.com","password"=> Hash::make("12345678")],["name"=>"User","email"=>"user@gmail.com","password"=> Hash::make("12345678")]]);
    }
}
