<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruckLoadPassengerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_load_passenger', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('ratchet_srtap_qty11_id')->unsigned()->nullable();
            $table->foreign('ratchet_srtap_qty11_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('red_setting_cushions_id')->unsigned()->nullable();
            $table->foreign('red_setting_cushions_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('white_setting_cushions_id')->unsigned()->nullable();
            $table->foreign('white_setting_cushions_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('roll_blue_paper_towels_id')->unsigned()->nullable();
            $table->foreign('roll_blue_paper_towels_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('black_rubber_monument_pads_id')->unsigned()->nullable();
            $table->foreign('black_rubber_monument_pads_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('screw_drivers_id')->unsigned()->nullable();
            $table->foreign('screw_drivers_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('pliers_id')->unsigned()->nullable();
            $table->foreign('pliers_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('box_knife_id')->unsigned()->nullable();
            $table->foreign('box_knife_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('tape_id')->unsigned()->nullable();
            $table->foreign('tape_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('tubes_gray_silicone_id')->unsigned()->nullable();
            $table->foreign('tubes_gray_silicone_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('squirt_bottle_coleman_full_id')->unsigned()->nullable();
            $table->foreign('squirt_bottle_coleman_full_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('scrub_bush_id')->unsigned()->nullable();
            $table->foreign('scrub_bush_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('spray_bottle_windex_id')->unsigned()->nullable();
            $table->foreign('spray_bottle_windex_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('ft_level2_id')->unsigned()->nullable();
            $table->foreign('ft_level2_id')->references('id')->on('truck_load_work_orders');

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
        Schema::dropIfExists('truck_load_passenger');
    }
}
