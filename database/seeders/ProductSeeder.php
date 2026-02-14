<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('products')->insert(
            [
            'product_number' => 181,
            'product_name' => '	2-0X1-0X0-4 GRASSER MILLSTONE',
            'category_id' => 1,
            'product_cost' => 	251.50
            ],
            [
            'product_number' => 229,
            'product_name' => '	3-0X0-6X1-8 TABLET MILLSTONE',
            'category_id' => 1,
            'product_cost' => 	356.75,
            ]
        );
    }
}
