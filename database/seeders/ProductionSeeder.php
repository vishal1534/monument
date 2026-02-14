<?php

namespace Database\Seeders;

use App\Models\Production;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Production::factory()
            ->count(2)
            ->hasCollaboration(1)
            ->hasCorrespondence(1)
            ->hasInstallation(1)
            ->hasOrder(1)
            ->create();
    }
}
