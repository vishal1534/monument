<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DeliveryStoreLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('delivery_store_locations')->insert([
            ['title' => 'Independence'],
            ['title' => 'Blue Spring'],
            ['title' => 'Excelsior Springs']
        ]);
    }
}
