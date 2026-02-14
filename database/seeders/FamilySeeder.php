<?php

namespace Database\Seeders;

use App\Models\Family;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        \DB::table('families')->insert([
//            'address' => Str::random(5),
//            'city' => Str::random(5),
//            'state' => Str::random(5),
//            'zip' => Str::random(5),
//            'contact' => Str::random(5),
//            'phone' => Str::random(5),
//
//        ]);
        Family::factory()
            ->count(10)
            ->create();
    }
}
