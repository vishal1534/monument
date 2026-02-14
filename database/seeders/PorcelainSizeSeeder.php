<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PorcelainSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('porcelain_size')->insert([
            ['title' => '1.2 x 1.6 in - OC-1'],
            ['title' => '1.6 x 2.4 in - OC-1A'],
            ['title' => '1.9 x 2.8 in - OC-2'],
            ['title' => '2.4 x 3.2 in - OC-3'],
            ['title' => '2.8 x 3.5 in - OC-4'],
            ['title' => '3.2 x 3.9 in - OC-5'],
            ['title' => '8 x 10 cm - OC-5 Open Frame'],
            ['title' => '9 x 12 cm - OC-5 Frame Cover'],
            ['title' => '3.5 x 4.7 in - OC-6'],
            ['title' => '9 x 12 cm - OC-6 Open Frame'],
            ['title' => '3.9 x 4.1 in - OC-7'],
            ['title' => '4.3 x 5.9 in - OC-8'],
            ['title' => '5.1 x 7.1 in - OC-9'],
            ['title' => '13 x 18 cm - OC-9 Frame Cover'],
            ['title' => '5.9 x 7.9 in - OC-10'],
            ['title' => '7.1 x 9.5 in - OC-11'],
            ['title' => '3.9 in - ST-1'],
            ['title' => '5.9 in - ST-2'],
            ['title' => '5 x 7 in - RT-1'],
            ['title' => '7.1 x 9.5 in - RT-2'],
            ['title' => '8 x 10 in - RT-3'],
            ['title' => '4 x 6 in - RT-4'],
            ['title' => '3.6 x 4.2 in - RT-5'],
            ['title' => '3.9 in - HC-1'],
            ['title' => '5.9 in - HC-2'],
            ['title' => '5.9 in - RC-2']
        ]);
    }
}
