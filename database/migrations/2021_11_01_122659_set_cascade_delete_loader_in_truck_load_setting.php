<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetCascadeDeleteLoaderInTruckLoadSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('truck_load_setting', function (Blueprint $table) {
            $table->dropForeign(['gray_silicone_qty_id']);
            $table->foreign('gray_silicone_qty_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['brown_silicone_qty_id']);
            $table->foreign('brown_silicone_qty_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['caulk_gun_qty_id']);
            $table->foreign('caulk_gun_qty_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['tape_measure_qty_id']);
            $table->foreign('tape_measure_qty_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['torpedo_level_id']);
            $table->foreign('torpedo_level_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['marking_paint_id']);
            $table->foreign('marking_paint_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['pry_bar_id']);
            $table->foreign('pry_bar_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['scrapers_id']);
            $table->foreign('scrapers_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['box_knife_qty_id']);
            $table->foreign('box_knife_qty_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['blades_id']);
            $table->foreign('blades_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['hand_broom_id']);
            $table->foreign('hand_broom_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['trowel_id']);
            $table->foreign('trowel_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['masking_tape_id']);
            $table->foreign('masking_tape_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['scrapers1_id']);
            $table->foreign('scrapers1_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['screw_drivers1_id']);
            $table->foreign('screw_drivers1_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['string_line_id']);
            $table->foreign('string_line_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
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
        Schema::table('truck_load_setting', function (Blueprint $table) {
            //
        });
    }
}
