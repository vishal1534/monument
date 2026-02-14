<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruckLoadSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_load_setting', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('gray_silicone_qty_id')->unsigned()->nullable();
            $table->foreign('gray_silicone_qty_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('brown_silicone_qty_id')->unsigned()->nullable();
            $table->foreign('brown_silicone_qty_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('caulk_gun_qty_id')->unsigned()->nullable();
            $table->foreign('caulk_gun_qty_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('tape_measure_qty_id')->unsigned()->nullable();
            $table->foreign('tape_measure_qty_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('torpedo_level_id')->unsigned()->nullable();
            $table->foreign('torpedo_level_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('marking_paint_id')->unsigned()->nullable();
            $table->foreign('marking_paint_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('pry_bar_id')->unsigned()->nullable();
            $table->foreign('pry_bar_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('scrapers_id')->unsigned()->nullable();
            $table->foreign('scrapers_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('box_knife_qty_id')->unsigned()->nullable();
            $table->foreign('box_knife_qty_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('blades_id')->unsigned()->nullable();
            $table->foreign('blades_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('hand_broom_id')->unsigned()->nullable();
            $table->foreign('hand_broom_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('trowel_id')->unsigned()->nullable();
            $table->foreign('trowel_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('masking_tape_id')->unsigned()->nullable();
            $table->foreign('masking_tape_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('scrapers1_id')->unsigned()->nullable();
            $table->foreign('scrapers1_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('screw_drivers1_id')->unsigned()->nullable();
            $table->foreign('screw_drivers1_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('string_line_id')->unsigned()->nullable();
            $table->foreign('string_line_id')->references('id')->on('truck_load_work_orders');

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
        Schema::dropIfExists('truck_load_setting');
    }
}
