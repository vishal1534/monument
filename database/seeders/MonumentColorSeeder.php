<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MonumentColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('product_colors')->insert([
            ['color_title' => 'None'],
            ['color_title' => 'Concrete'],
            ['color_title' => 'Amer Black'],
            ['color_title' => 'Bahama Blue'],
            ['color_title' => 'Barre'],
            ['color_title' => 'Blue Pearl'],
            ['color_title' => 'Bronze'],
            ['color_title' => 'Camillion'],
            ['color_title' => 'China Gray'],
            ['color_title' => 'China Pink'],
            ['color_title' => 'Dakota Mahogany'],
            ['color_title' => 'Deer Brown'],
            ['color_title' => 'Impala Black'],
            ['color_title' => 'Indian Red'],
            ['color_title' => 'Melrose Black'],
            ['color_title' => 'Metal Craft'],
            ['color_title' => 'Mid Blue'],
            ['color_title' => 'Millstone Gray'],
            ['color_title' => 'Mis'],
            ['color_title' => 'Mole Red'],
            ['color_title' => 'Moonlight Gray'],
            ['color_title' => 'Morning Rose'],
            ['color_title' => 'Paradiso'],
            ['color_title' => 'Rushmore'],
            ['color_title' => 'Salisbury'],
            ['color_title' => 'St. Cloud Gray'],
            ['color_title' => 'Sunset'],
            ['color_title' => 'Wausau Red'],
            ['color_title' => 'Olive Green'],
            ['color_title' => 'Cats Eye Red'],
            ['color_title' => 'Flash Back'],
            ['color_title' => 'Sa Impala']
        ]);
    }
}
