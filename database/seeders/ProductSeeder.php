<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Laptop', 'description' => 'This is Laptop', 'price' => 10000000, 'image' => 'laptop.jpg', 'category_id' => 1],
            ['name' => 'T-Shirt', 'description' => 'This is T-Shirt', 'price' => 25000, 'image' => 't-shirt.jpg', 'category_id' => 2],
        ];

        DB::table('products')->insert($products);
    }
}
