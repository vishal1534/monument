<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            'first_name' => Str::random(5),
            'last_name' => Str::random(5),
            'email' => Str::random(5).'@example.com',
            'email_verified_at' => '2021-01-07 10:36:15',
            'role_id' => 1,
        ]);
    }
}
