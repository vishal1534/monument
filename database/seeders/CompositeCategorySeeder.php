<?php

namespace Database\Seeders;

use App\Models\CompositeCategory;
use Illuminate\Database\Seeder;

class CompositeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $composite = [
            [
                'title' => 'Composite'

            ],
            [
                'title' => 'Grouped'

            ],
            [
                'title' => 'Rectangle'
            ],
            [
                'title' => 'testing'

            ]
        ];

        foreach ($composite as $key => $value) {
            CompositeCategory::create($value);
        }
    }
}
