<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductMonumentPolishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productPolish = [
            ['product_polish_title'=> 'None'],
            ['product_polish_title'=> 'P2'],
            ['product_polish_title'=> 'P3'],
            ['product_polish_title'=> 'P5'],
            ['product_polish_title'=> '2 Pol Margin'],
            ['product_polish_title'=> 'Tapart Front'],
            ['product_polish_title'=> 'Polish Top'],
            ['product_polish_title'=> 'Sawn Back'],
            ['product_polish_title'=> 'Pol-Front & Back'],
            ['product_polish_title'=> 'Special Margin'],
            ['product_polish_title'=> 'Bevel frt 2"pm Brp'],
            ['product_polish_title'=> 'Bevel frt Brp'],
        ];
        foreach ($productPolish as $polish)
        {
            \DB::table('monument_polish')->insert($polish);
        }
    }
}
