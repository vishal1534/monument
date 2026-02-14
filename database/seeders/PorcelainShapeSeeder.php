<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PorcelainShapeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('porcelain_shapes')->insert([
            ['title' => 'Oval'],
            ['title' => 'Square'],
            ['title' => 'Heart'],
            ['title' => 'Frame Cover'],
            ['title' => 'Rectangle'],
            ['title' => 'Round']
        ]);
    }
}
