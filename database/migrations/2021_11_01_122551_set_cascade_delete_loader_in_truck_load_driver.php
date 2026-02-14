<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetCascadeDeleteLoaderInTruckLoadDriver extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('truck_load_driver', function (Blueprint $table) {
            $table->dropForeign(['come_along_id']);
            $table->foreign('come_along_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['roll_rope_id']);
            $table->foreign('roll_rope_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['xtra_straps_id']);
            $table->foreign('xtra_straps_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['flash_light_id']);
            $table->foreign('flash_light_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['crow_bar_id']);
            $table->foreign('crow_bar_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['sledge_id']);
            $table->foreign('sledge_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['hatchet_id']);
            $table->foreign('hatchet_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['crane_control_id']);
            $table->foreign('crane_control_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['blue_tool_box_id']);
            $table->foreign('blue_tool_box_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['cable_lock_id']);
            $table->foreign('cable_lock_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['d_2_sprayer_id']);
            $table->foreign('d_2_sprayer_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
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
        Schema::table('truck_load_driver', function (Blueprint $table) {
            //
        });
    }
}
