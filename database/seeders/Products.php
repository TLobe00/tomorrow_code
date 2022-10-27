<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class Products extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('products')->delete();

        $products = [
            ['id' => 1, 'code' => 'A', 'price' => 200],
            ['id' => 2, 'code' => 'B', 'price' => 1000],
            ['id' => 3, 'code' => 'C', 'price' => 125],
            ['id' => 4, 'code' => 'D', 'price' => 15],
            ['id' => 5, 'code' => 'E', 'price' => 200],
        ];

        DB::table('products')->insert($products);

    }
}