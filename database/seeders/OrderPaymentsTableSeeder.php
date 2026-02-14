<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderPaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('order_payments')->insert([
            [
                'order_payment_date' => '24/11/20',
                'order_payment_amount' => 2499,
                'order_id' => 1

            ]
        ]);
    }
}
