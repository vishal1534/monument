<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserResource;

class ResourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $resources = [
          ['title' => 'Quotes'],
          ['title' => 'Orders'],
          ['title' => 'Cemetery'],
          ['title' => 'Products'],
          ['title' => 'Collaboration'],
          ['title' => 'Production'],
          ['title' => 'Installation'],
          ['title' => 'Accounting'],
          ['title' => 'Maintenance'],
          ['title' => 'Department'],
          ['title' => 'Setting'],
          ['title' => 'User'],
          ['title' => 'PO'],
      ];
      foreach ($resources as $key => $val){
          UserResource::create($val);
      }
    }
}
