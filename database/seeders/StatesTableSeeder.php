<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
       /* \DB::table('states')->insert([
            ['id' => '1', 'state_title' => 'AR'],
            ['id' => '2', 'state_title' => 'MO'],
            ['id' => '3', 'state_title' => 'KS'],
            ['id' => '4', 'state_title' => 'Denver'],
            ['id' => '5', 'state_title' => 'Kansas'],
            ['id' => '6', 'state_title' => 'MOMO'],
            ['id' => '7', 'state_title' => 'OK']
        ]);*/
        $existingStates = [
            ['id' => '1', 'state_title' => 'Alaska'],
            ['id' => '2', 'state_title' => 'Texas'],
            ['id' => '3', 'state_title' => 'California'],
            ['id' => '4', 'state_title' => 'Montana'],
            ['id' => '5', 'state_title' => 'New Mexico'],
            ['id' => '6', 'state_title' => 'Arizona'],
            ['id' => '7', 'state_title' => 'Nevada']
        ];

        foreach ($existingStates as $state){
            \DB::table('states')->where('id', $state['id'])->update(['state_title' => $state['state_title'] ]);
        }

        \DB::table('states')->insert([
            ['id' => '15', 'state_title' => 'Colorado'],
            ['id' => '16', 'state_title' => 'Oregon'],
            ['id' => '17', 'state_title' => 'Wyoming'],
            ['id' => '18', 'state_title' => 'Michigan'],
            ['id' => '19', 'state_title' => 'Minnesota'],
            ['id' => '20', 'state_title' => 'Utah'],
            ['id' => '21', 'state_title' => 'Idaho'],
            ['id' => '22', 'state_title' => 'Kansas'],
            ['id' => '23', 'state_title' => 'Nebraska'],
            ['id' => '24', 'state_title' => 'South Dakota'],
            ['id' => '25', 'state_title' => 'Washington'],
            ['id' => '26', 'state_title' => 'North Dakota'],
            ['id' => '27', 'state_title' => 'Oklahoma'],
            ['id' => '28', 'state_title' => 'Missouri'],
            ['id' => '29', 'state_title' => 'Florida'],
            ['id' => '30', 'state_title' => 'Wisconsin'],
            ['id' => '31', 'state_title' => 'Georgia'],
            ['id' => '32', 'state_title' => 'Illinois'],
            ['id' => '33', 'state_title' => 'Iowa'],
            ['id' => '34', 'state_title' => 'New York'],
            ['id' => '35', 'state_title' => 'North Carolina'],
            ['id' => '36', 'state_title' => 'Arkansas'],
            ['id' => '37', 'state_title' => 'Alabama'],
            ['id' => '38', 'state_title' => 'Louisiana'],
            ['id' => '39', 'state_title' => 'Mississippi'],
            ['id' => '40', 'state_title' => 'Pennsylvania'],
            ['id' => '41', 'state_title' => 'Ohio'],
            ['id' => '42', 'state_title' => 'Virginia'],
            ['id' => '43', 'state_title' => 'Tennessee'],
            ['id' => '44', 'state_title' => 'Kentucky'],
            ['id' => '45', 'state_title' => 'Indiana'],
            ['id' => '46', 'state_title' => 'Maine'],
            ['id' => '47', 'state_title' => 'South Carolina'],
            ['id' => '48', 'state_title' => 'West Virginia'],
            ['id' => '49', 'state_title' => 'Maryland'],
            ['id' => '50', 'state_title' => 'Hawaii'],
            ['id' => '51', 'state_title' => 'Massachusetts'],
            ['id' => '52', 'state_title' => 'Vermont'],
            ['id' => '53', 'state_title' => 'New Hampshire'],
            ['id' => '54', 'state_title' => 'New Jersey'],
            ['id' => '55', 'state_title' => 'Connecticut'],
            ['id' => '56', 'state_title' => 'Delaware'],
            ['id' => '57', 'state_title' => 'Rhode Island']
        ]);
    }
}
