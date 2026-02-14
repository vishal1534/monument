<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('stores')->insert([
           [
              'subdomain' => null
           ] ,
        ]);
    }
}
