<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruckLoadBackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_load_back', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('setting_dolly_id')->unsigned()->nullable();
            $table->foreign('setting_dolly_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('granite_seal_id')->unsigned()->nullable();
            $table->foreign('granite_seal_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('shovel_id')->unsigned()->nullable();
            $table->foreign('shovel_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('sharp_shooter_shovel_id')->unsigned()->nullable();
            $table->foreign('sharp_shooter_shovel_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('hoe_id')->unsigned()->nullable();
            $table->foreign('hoe_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('rake_id')->unsigned()->nullable();
            $table->foreign('rake_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('pick_ax_id')->unsigned()->nullable();
            $table->foreign('pick_ax_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('ft_level_4_id')->unsigned()->nullable();
            $table->foreign('ft_level_4_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('manual_post_hole_digger_id')->unsigned()->nullable();
            $table->foreign('manual_post_hole_digger_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('gas_post_hole_auger_id')->unsigned()->nullable();
            $table->foreign('gas_post_hole_auger_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('dingo_roller_bar_id')->unsigned()->nullable();
            $table->foreign('dingo_roller_bar_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('crane_roller_bar_id')->unsigned()->nullable();
            $table->foreign('crane_roller_bar_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('tamper_id')->unsigned()->nullable();
            $table->foreign('tamper_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('wheel_barrow_id')->unsigned()->nullable();
            $table->foreign('wheel_barrow_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('orange_pinch_bar_id')->unsigned()->nullable();
            $table->foreign('orange_pinch_bar_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('blue_roller_id')->unsigned()->nullable();
            $table->foreign('blue_roller_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('two_wheel_chalks_id')->unsigned()->nullable();
            $table->foreign('two_wheel_chalks_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('water_buckets_id')->unsigned()->nullable();
            $table->foreign('water_buckets_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('two_by_fours_id')->unsigned()->nullable();
            $table->foreign('two_by_fours_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('one_by_fours_id')->unsigned()->nullable();
            $table->foreign('one_by_fours_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('grass_seed_id')->unsigned()->nullable();
            $table->foreign('grass_seed_id')->references('id')->on('truck_load_work_orders');
            $table->bigInteger('bucket_pea_gravel_id')->unsigned()->nullable();
            $table->foreign('bucket_pea_gravel_id')->references('id')->on('truck_load_work_orders');

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
        Schema::dropIfExists('truck_load_back');
    }
}
