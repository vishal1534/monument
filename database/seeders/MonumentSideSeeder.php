<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MonumentSideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('product_sides')->insert([
            ['side_title' => 'None'],
            ['side_title' => 'Side'],
            ['side_title' => 'Sawn-1']
        ]);
    }
}
