<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MonumentShapeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('product_shapes')->insert([
            ['shape_title' => 'None'],
            ['shape_title' => 'Serp Top'],
            ['shape_title' => 'Single Heart'],
            ['shape_title' => 'Oval Top'],
            ['shape_title' => 'Special Shape'],
            ['shape_title' => 'Rectangle']
        ]);
    }
}
