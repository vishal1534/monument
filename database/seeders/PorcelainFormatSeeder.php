<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PorcelainFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('porcelain_formats')->insert([
            ['title' => 'Oval (Vertical)'],
            ['title' => 'Oval (Horizontal)'],
            ['title' => 'Bust'],
            ['title' => 'Full Figure'],
            ['title' => 'Other (see instructions)']
        ]);
    }
}
