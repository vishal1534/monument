<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PorcelainPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('porcelain_parts')->insert([
            ['title' => '157'],
            ['title' => '166'],
            ['title' => '246'],
            ['title' => '279'],
            ['title' => '492'],
            ['title' => '614'],
            ['title' => '640'],
            ['title' => '773'],
            ['title' => '943'],
            ['title' => '955'],
            ['title' => '1032'],
            ['title' => '1222'],
            ['title' => '1432'],
            ['title' => '1845'],
            ['title' => '1846'],
            ['title' => '1847'],
            ['title' => '1848'],
            ['title' => '1849'],
            ['title' => '1850'],
            ['title' => '1851'],
            ['title' => '1852'],
            ['title' => '1853'],
            ['title' => '2409'],
            ['title' => '2410'],
            ['title' => '2652'],
            ['title' => '2800'],
            ['title' => '3256'],
        ]);

    }
}
