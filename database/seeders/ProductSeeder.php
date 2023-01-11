<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            Product::insert([
                "title" => Str::random(10),
                "description" => Str::random(40),
                "price" => rand(100, 50000),
                "quantity" => rand(2, 50),
                "unit" => "Piece",
            ]);
        }
    }
}
