<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaperLocation;

class PaperLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newPaperLoaction = [
          ["title" => "Angel's Desk"],
            ["title" => "Bronze PO Box"],
            ["title" => "Blast House"],
            ["title" => "Colton's Desk"],
            ["title" => "Completed"],
            ["title" => "Kevin's Desk"],
            ["title" => "Final Date Dept."],
            ["title" => "Final Dates Need Rubbing"],
            ["title" => "Image Mart Box"],
            ["title" => "Install That Need Paid Box"],
            ["title" => "Install Scheduled Box"],
            ["title" => "Monuments Ready To Install Box"],
            ["title" => "Nathan's Desk"],
            ["title" => "New Orders To Process"],
            ["title" => "Order Ready To Laser Box"],
            ["title" => "Pickups That Are Paid Box"],
            ["title" => "Pickups That Need Paid Box"],
            ["title" => "Stencil To Cut Box"],
            ["title" => "Orders Waiting On Monu., Vases & Access Box"],
            ["title" => "Orders Out Of Blasthouse/Laser Room Box"],
            ["title" => "Waiting On Customer Box"],
            ["title" => "Waiting On Cemetery Box"],
            ["title" => "Waiting On Cemetery To Flag"]
        ];
        foreach ($newPaperLoaction as $item => $value)
        {
            PaperLocation::create($value);
        }
    }
}
