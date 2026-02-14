<?php

namespace Database\Seeders;

use App\Models\SimpleCategory;
use Illuminate\Database\Seeder;

class SimpleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $simple = [
            [
                'title' => 'Jewelry'

            ],
            [
                'title' => 'Marks'

            ]
        ];

        foreach ($simple as $key => $value) {
            SimpleCategory::create($value);
        }
    }
}
