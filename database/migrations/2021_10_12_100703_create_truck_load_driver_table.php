<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruckLoadDriverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_load_driver', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('come_along_id')->unsigned()->nullable();
            $table->foreign('come_along_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('roll_rope_id')->unsigned()->nullable();
            $table->foreign('roll_rope_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('xtra_straps_id')->unsigned()->nullable();
            $table->foreign('xtra_straps_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('flash_light_id')->unsigned()->nullable();
            $table->foreign('flash_light_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('crow_bar_id')->unsigned()->nullable();
            $table->foreign('crow_bar_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('sledge_id')->unsigned()->nullable();
            $table->foreign('sledge_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('hatchet_id')->unsigned()->nullable();
            $table->foreign('hatchet_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('crane_control_id')->unsigned()->nullable();
            $table->foreign('crane_control_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('blue_tool_box_id')->unsigned()->nullable();
            $table->foreign('blue_tool_box_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('cable_lock_id')->unsigned()->nullable();
            $table->foreign('cable_lock_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('d_2_sprayer_id')->unsigned()->nullable();
            $table->foreign('d_2_sprayer_id')->references('id')->on('truck_load_work_orders');

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
        Schema::dropIfExists('truck_load_driver');
    }
}
