<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $department = [
            ['title' => 'Angel'],
            ['title' => 'Blast House'],
            ['title' => 'Cemetery Dept.'],
            ['title' => 'Colton'],
            ['title' => 'Design Dept.'],
            ['title' => 'Final Date Dept.'],
            ['title' => 'Kevin'],
            ['title' => 'Installation Dept.'],
            ['title' => 'Laser Room'],
            ['title' => 'Nathan'],
            ['title' => 'Porcelain Dept.'],
            ['title' => 'Purchasing Dept.'],
            ['title' => 'Order Entry'],

        ];
        foreach ($department as $dep => $value)
        {
            Department::create($value);
        }
    }
}
