<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class Promotions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('promotions')->delete();

        $promotions = [
            ['id' => 1, 'product_id' => 1, 'product_qty' => 5, 'ref_product_id' => NULL, 'ref_product_qty' => NULL, 'new_price' => 900],
            ['id' => 2, 'product_id' => 3, 'product_qty' => 6, 'ref_product_id' => NULL, 'ref_product_qty' => NULL, 'new_price' => 600],
            ['id' => 3, 'product_id' => 5, 'product_qty' => 1, 'ref_product_id' => 2, 'ref_product_qty' => 1, 'new_price' => 0],
        ];

        DB::table('promotions')->insert($promotions);
    }
}
