<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetCascadeDeleteLoaderInTruckLoadMaintenance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('truck_load_maintenance', function (Blueprint $table) {
            $table->dropForeign(['ck_engine_oil_id']);
            $table->foreign('ck_engine_oil_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['ck_tire_pressure_id']);
            $table->foreign('ck_tire_pressure_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['ck_oil_level_id']);
            $table->foreign('ck_oil_level_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['truck_load_list_id']);
            $table->foreign('truck_load_list_id')->references('id')->on('truck_load_list')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('truck_load_maintenance', function (Blueprint $table) {
            //
        });
    }
}
