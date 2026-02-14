<?php

namespace Database\Seeders;


use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $store = [
            [
                'name' => 'Monument Store',
                'store_address' => '4836 Counts Lane Lexington, KY 40509',

            ],
            [
                'name' => 'Penny C. Hill',
                'store_address' => '4033 Graystone Lakes Macon, GA 31201',

            ],
            [
                'name' => 'Jamie Mansergh',
                'store_address' => '4871 Columbia Mine Road Huntington, WV 25705',

            ],
            [
                'name' => 'Ryder Lakeland',
                'store_address' => '3095 Rockford Road Cambridge, MA 02141',

            ],
            [
                'name' => 'UK Store ',
                'store_address' => 'UK Store Location9',

            ],
        ];

        foreach ($store as $key => $value) {
            Store::create($value);
        }
    }
}
