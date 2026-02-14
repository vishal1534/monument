<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('countries')->insert([
            ['country_title' => 'USA'],
            ['country_title' => 'UK'],
            ['country_title' => 'Canada'],
            ['country_title' => 'Australia'],
            ['country_title' => 'Germany'],
            ['country_title' => 'France'],
            ['country_title' => 'Test']
        ]);
    }
}
