<?php

namespace Database\Seeders;

use App\Http\Controllers\MonumentTypeController;
use App\Models\CollaboratorType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    //CMD: php artisan migrate:fresh --seed
    //for fresh seeder
    public function run()
    {
        $this->call([
//            UserRolesSeeder::class,
//            UserSeeder::class,
//            ProductSeeder::class,
//            CompositeSeeder::class,
//            ServiceSeeder::class,
//            ProductionSeeder::class,
            AdminStoreSeeder::class,
            AdminUserRoleSeeder::class,
            AdminUserSeeder::class,
            PaperLocationSeeder::class,
            CollaborationTypeSeeder::class,
            CountriesSeeder::class,
            DepartmentSeeder::class,
            CompositeCategorySeeder::class,
            SimpleCategorySeeder::class,
            ServiceCategorySeeder::class,
            StatesTableSeeder::class,
            CountiesTableSeeder::class,
            CitiesTableSeeder::class,
            CemeteryCategoriesTableSeeder::class,
            CustomerRolesSeeder::class,
            MonumentColorSeeder::class,
            MonumentShapeSeeder::class,
            MonumentSideSeeder::class,
            MonumentTypeSeeder::class,
            ResourcesSeeder::class,
            PorcelainFormatSeeder::class,
            PorcelainOrientationSeeder::class,
            PorcelainPartSeeder::class,
            PorcelainShapeSeeder::class,
            PorcelainSizeSeeder::class,
        ]);
    }
}
