<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AddAdminStoreIDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = ['quotes', 'orders', 'collaborations', 'productions', 'installations', 'companies', 'cemeteries', 'monuments', 'services', 'simples', 'composites'
        ,'collaborators', 'collaborator_types', 'product_colors', 'product_types', 'product_shapes', 'product_sides', 'monument_polish', 'countries', 'service_category',
            'simple_categories', 'composite_category', 'production_oc_pictures', 'production_sandblastings', 'production_lasers', 'weekly_schedules', 'installers',
            'loaders','installation_productions', 'po_orders', 'suppliers', 'equipments', 'maintenance_work_orders', 'departments', 'order_statuses', 'paper_location'];
        $storeID = \DB::table('stores')->first();
        foreach($tables as $table){
            $tableNotEmpty = \DB::table($table)->exists();
            if ($tableNotEmpty){
                \DB::table($table)->update(['store_id' => $storeID->id]);
            }
        }
    }
}
