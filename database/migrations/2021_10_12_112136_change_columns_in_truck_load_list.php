<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsInTruckLoadList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('truck_load_list', function (Blueprint $table) {
           $table->dropColumn('ck_engine_oil');
            $table->dropColumn('ck_tire_pressure');
            $table->dropColumn('ck_oil_level');
            $table->dropColumn('come_along');
            $table->dropColumn('crane_control');
            $table->dropColumn('blue_tool_box');
            $table->dropColumn('cable_lock');
            $table->dropColumn('crow_bar');
            $table->dropColumn('d_2_sprayer');
            $table->dropColumn('flash_light');
            $table->dropColumn('hatchet');
            $table->dropColumn('roll_rope');
            $table->dropColumn('sledge');
            $table->dropColumn('xtra_straps');
            $table->dropColumn('black_rubber_monument_pads');
            $table->dropColumn('box_knife');
            $table->dropColumn('ft_level2');
            $table->dropColumn('pliers');
            $table->dropColumn('ratchet_srtap_qty11');
            $table->dropColumn('red_setting_cushions');
            $table->dropColumn('roll_blue_paper_towels');
            $table->dropColumn('screw_drivers');
            $table->dropColumn('scrub_bush');
            $table->dropColumn('spray_bottle_windex');
            $table->dropColumn('squirt_bottle_coleman_full');
            $table->dropColumn('tape');
            $table->dropColumn('tubes_gray_silicone');
            $table->dropColumn('white_setting_cushions');
            $table->dropColumn('bag_for_dirt');
            $table->dropColumn('black_blankets');
            $table->dropColumn('emergency_stuff');
            $table->dropColumn('fire_ext');
            $table->dropColumn('gray_tarp');
            $table->dropColumn('install_check_list');
            $table->dropColumn('jumper_cabels');
            $table->dropColumn('marking_pencil_wax');
            $table->dropColumn('monument_tags_cards');
            $table->dropColumn('probe');
            $table->dropColumn('rubbing_paper');
            $table->dropColumn('tire_repair_kit');
            $table->dropColumn('blue_roller');
            $table->dropColumn('bucket_pea_gravel');
            $table->dropColumn('crane_roller_bar');
            $table->dropColumn('dingo_roller_bar');
            $table->dropColumn('ft_level_4');
            $table->dropColumn('gas_post_hole_auger');
            $table->dropColumn('granite_seal');
            $table->dropColumn('grass_seed');
            $table->dropColumn('hoe');
            $table->dropColumn('manual_post_hole_digger');
            $table->dropColumn('one_by_fours');
            $table->dropColumn('orange_pinch_bar');
            $table->dropColumn('pick_ax');
            $table->dropColumn('rake');
            $table->dropColumn('setting_dolly');
            $table->dropColumn('sharp_shooter_shovel');
            $table->dropColumn('shovel');
            $table->dropColumn('tamper');
            $table->dropColumn('two_by_fours');
            $table->dropColumn('two_wheel_chalks');
            $table->dropColumn('water_buckets_qty');
            $table->dropColumn('wheel_barrow');
            $table->dropColumn('blades');
            $table->dropColumn('bpx_knife_qty');
            $table->dropColumn('brown_silicone_qty');
            $table->dropColumn('caulk_gun_qty');
            $table->dropColumn('gray_silicone_qty');
            $table->dropColumn('hand_broom');
            $table->dropColumn('marking_paint');
            $table->dropColumn('masking_tape');
            $table->dropColumn('pry_bar');
            $table->dropColumn('scrapers');
            $table->dropColumn('scrapers1');
            $table->dropColumn('screw_drivers1');
            $table->dropColumn('string_line');
            $table->dropColumn('tape_measure_qty');
            $table->dropColumn('torpedo_level');
            $table->dropColumn('trowel');
            $table->dropColumn('checker_sign');
            $table->dropColumn('installer_sign');
            $table->bigInteger('truck_load_maintenance_id')->unsigned()->nullable();
            $table->foreign('truck_load_maintenance_id')->references('id')->on('truck_load_maintenance');
            $table->bigInteger('truck_load_driver_id')->unsigned()->nullable();
            $table->foreign('truck_load_driver_id')->references('id')->on('truck_load_driver');
            $table->bigInteger('truck_load_passenger_id')->unsigned()->nullable();
            $table->foreign('truck_load_passenger_id')->references('id')->on('truck_load_passenger');
            $table->bigInteger('truck_load_inside_id')->unsigned()->nullable();
            $table->foreign('truck_load_inside_id')->references('id')->on('truck_load_inside');
            $table->bigInteger('truck_load_back_id')->unsigned()->nullable();
            $table->foreign('truck_load_back_id')->references('id')->on('truck_load_back');
            $table->bigInteger('truck_load_setting_id')->unsigned()->nullable();
            $table->foreign('truck_load_setting_id')->references('id')->on('truck_load_setting');

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
