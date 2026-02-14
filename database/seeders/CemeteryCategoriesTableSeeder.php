<?php

namespace Database\Seeders;

use App\Models\CemeteryCategory;
use Illuminate\Database\Seeder;

class CemeteryCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $cemetery = [
            [
                'title' => 'Cemetery'

            ]
        ];

        foreach ($cemetery as $key => $value) {
            CemeteryCategory::create($value);
        }
    }
}
