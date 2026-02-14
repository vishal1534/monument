<?php

namespace Database\Seeders;

use App\Models\CollaboratorType;
use Illuminate\Database\Seeder;

class CollaboratorTypes extends Seeder
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
            ]
        ];

        foreach ($types as $type => $value) {
            CollaboratorType::create($value);
        }
    }
}
