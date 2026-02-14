<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PorcelainOrientationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('porcelain_orientations')->insert([
            ['title' => 'Vertical'],
            ['title' => 'Horizontal'],
            ['title' => 'Not applicable']
        ]);
    }
}
