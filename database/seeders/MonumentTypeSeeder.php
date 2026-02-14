<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MonumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('product_types')->insert([
            ['type_title' => 'None'],
            ['type_title' => 'Base'],
            ['type_title' => 'Bevel'],
            ['type_title' => 'Benches'],
            ['type_title' => 'Bricks'],
            ['type_title' => 'Bronze'],
            ['type_title' => 'Clearance'],
            ['type_title' => 'Combo'],
            ['type_title' => 'Cremation'],
            ['type_title' => 'Eq Parts'],
            ['type_title' => 'Final Date '],
            ['type_title' => 'Foundation Cap'],
            ['type_title' => 'Grasser'],
            ['type_title' => 'OrderInstallation'],
            ['type_title' => 'Ledger'],
            ['type_title' => 'Military'],
            ['type_title' => 'Mis'],
            ['type_title' => 'Pet'],
            ['type_title' => 'Picture'],
            ['type_title' => 'Rock'],
            ['type_title' => 'Sandblasting'],
            ['type_title' => 'Slant'],
            ['type_title' => 'Statue'],
            ['type_title' => 'Supplies'],
            ['type_title' => 'Tablet'],
            ['type_title' => 'Tiles Etched'],
            ['type_title' => 'mTest'],
            ['type_title' => 'Vase'],
            ['type_title' => 'Vase Collar']
        ]);
    }
}
