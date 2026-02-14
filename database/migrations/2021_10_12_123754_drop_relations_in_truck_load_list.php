<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropRelationsInTruckLoadList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('truck_load_list', function (Blueprint $table) {
            $table->dropForeign(['truck_load_maintenance_id']);
            $table->dropColumn('truck_load_maintenance_id');
            $table->dropForeign(['truck_load_driver_id']);
            $table->dropColumn('truck_load_driver_id');
            $table->dropForeign(['truck_load_passenger_id']);
            $table->dropColumn('truck_load_passenger_id');
            $table->dropForeign(['truck_load_inside_id']);
            $table->dropColumn('truck_load_inside_id');
            $table->dropForeign(['truck_load_back_id']);
            $table->dropColumn('truck_load_back_id');
            $table->dropForeign(['truck_load_setting_id']);
            $table->dropColumn('truck_load_setting_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('truck_load_list', function (Blueprint $table) {
            //
        });
    }
}
