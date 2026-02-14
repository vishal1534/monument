<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruckLoadMaintenanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_load_maintenance', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('ck_engine_oil_id')->unsigned()->nullable();
            $table->foreign('ck_engine_oil_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('ck_tire_pressure_id')->unsigned()->nullable();
            $table->foreign('ck_tire_pressure_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('ck_oil_level_id')->unsigned()->nullable();
            $table->foreign('ck_oil_level_id')->references('id')->on('truck_load_work_orders');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('truck_load_maintenance');
    }
}
