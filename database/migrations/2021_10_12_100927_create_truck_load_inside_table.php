<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruckLoadInsideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_load_inside', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('black_blankets_id')->unsigned()->nullable();
            $table->foreign('black_blankets_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('rubbing_paper_id')->unsigned()->nullable();
            $table->foreign('rubbing_paper_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('jumper_cabels_id')->unsigned()->nullable();
            $table->foreign('jumper_cabels_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('emergency_stuff_id')->unsigned()->nullable();
            $table->foreign('emergency_stuff_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('fire_ext_id')->unsigned()->nullable();
            $table->foreign('fire_ext_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('probe_id')->unsigned()->nullable();
            $table->foreign('probe_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('install_check_list_id')->unsigned()->nullable();
            $table->foreign('install_check_list_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('marking_pencil_wax_id')->unsigned()->nullable();
            $table->foreign('marking_pencil_wax_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('gray_tarp_id')->unsigned()->nullable();
            $table->foreign('gray_tarp_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('tire_repair_kit_id')->unsigned()->nullable();
            $table->foreign('tire_repair_kit_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('bag_for_dirt_id')->unsigned()->nullable();
            $table->foreign('bag_for_dirt_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('monument_tags_cards_id')->unsigned()->nullable();
            $table->foreign('monument_tags_cards_id')->references('id')->on('truck_load_work_orders');

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
        Schema::dropIfExists('truck_load_inside');
    }
}
