<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CustomerRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('customer_roles')->insert([
            ['title' => 'Distributor'],
            ['title' => 'Sign'],
            ['title' => 'Sandblasting'],
            ['title' => 'Other']
            ]);
    }
}
