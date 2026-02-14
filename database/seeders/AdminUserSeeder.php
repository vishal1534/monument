<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supperAdmin = \DB::table('user_roles')->whereTitle('Supper Admin')->first();
        $storeID = \DB::table('stores')->first();
        \DB::table('users')->insert([
            'name' => 'dev',
            'email' =>'dev@uforiainfotech.com',
            'password' =>'$2y$10$Kdy/Tv6i5cLmc1JQBInlzuASq/ED3w81tAzt3U0dOHehqQd1RK8Ai',
            'email_verified_at' => '2021-01-07 10:36:15',
            'password_status'=>1,
            'status'=>1,
            'role_id' => 1,
            'store_id' => $storeID->id,
        ]);

        \DB::table('users')->insert([
            'name' => 'Supper Admin',
            'email' =>'supperadmin@uforiainfotech.com',
            'password' =>'$2y$10$Kdy/Tv6i5cLmc1JQBInlzuASq/ED3w81tAzt3U0dOHehqQd1RK8Ai',
            'email_verified_at' => '2021-01-07 10:36:15',
            'password_status'=>1,
            'status'=>1,
            'role_id' => $supperAdmin->id,
        ]);
    }
}
