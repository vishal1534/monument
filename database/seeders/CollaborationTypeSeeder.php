<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CollaboratorType;

class CollaborationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'title' => 'Vendor'
            ],
            [
                'title' => 'Cemetery'
            ],
            [
                'title' => 'Production'
            ],
            [
                'title' => 'Customer'
            ],
            [
                'title' => 'Design'
            ]
        ];

        foreach ($types as $type => $value) {
            CollaboratorType::create($value);
        }
    }
}
