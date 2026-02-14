<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompositeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('composites')->insert([
            'composite_name' => 'dummy-composite',
            'category_id' => '1',
        ]);
    }
}
