<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruckLoadListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_load_list', function (Blueprint $table) {
            $table->id();
            $table->string('installer_name')->nullable();
            $table->string('checker_name')->nullable();
            $table->tinyInteger('ck_engine_oil')->nullable()->comments('0 for fill, 1 for replace, 2 for add');
            $table->tinyInteger('ck_tire_pressure')->nullable();
            $table->tinyInteger('ck_oil_level')->nullable();
            $table->tinyInteger('come_along')->nullable();
            $table->tinyInteger('crane_control')->nullable();
            $table->tinyInteger('blue_tool_box')->nullable();
            $table->tinyInteger('cable_lock')->nullable();
            $table->tinyInteger('crow_bar')->nullable();
            $table->tinyInteger('d_2_sprayer')->nullable();
            $table->tinyInteger('flash_light')->nullable();
            $table->tinyInteger('hatchet')->nullable();
            $table->tinyInteger('roll_rope')->nullable();
            $table->tinyInteger('sledge')->nullable();
            $table->tinyInteger('xtra_straps')->nullable();
            $table->tinyInteger('black_rubber_monument_pads')->nullable();
            $table->tinyInteger('box_knife')->nullable();
            $table->tinyInteger('ft_level2')->nullable();
            $table->tinyInteger('pliers')->nullable();
            $table->tinyInteger('ratchet_srtap_qty11')->nullable();
            $table->tinyInteger('red_setting_cushions')->nullable();
            $table->tinyInteger('roll_blue_paper_towels')->nullable();
            $table->tinyInteger('screw_drivers')->nullable();
            $table->tinyInteger('scrub_bush')->nullable();
            $table->tinyInteger('spray_bottle_windex')->nullable();
            $table->tinyInteger('squirt_bottle_coleman_full')->nullable();
            $table->tinyInteger('tape')->nullable();
            $table->tinyInteger('tubes_gray_silicone')->nullable();
            $table->tinyInteger('white_setting_cushions')->nullable();
            $table->tinyInteger('bag_for_dirt')->nullable();
            $table->tinyInteger('black_blankets')->nullable();
            $table->tinyInteger('emergency_stuff')->nullable();
            $table->tinyInteger('fire_ext')->nullable();
            $table->tinyInteger('gray_tarp')->nullable();
            $table->tinyInteger('install_check_list')->nullable();
            $table->tinyInteger('jumper_cabels')->nullable();
            $table->tinyInteger('marking_pencil_wax')->nullable();
            $table->tinyInteger('monument_tags_cards')->nullable();
            $table->tinyInteger('probe')->nullable();
            $table->tinyInteger('rubbing_paper')->nullable();
            $table->tinyInteger('tire_repair_kit')->nullable();
            $table->tinyInteger('blue_roller')->nullable();
            $table->tinyInteger('bucket_pea_gravel')->nullable();
            $table->tinyInteger('crane_roller_bar')->nullable();
            $table->tinyInteger('dingo_roller_bar')->nullable();
            $table->tinyInteger('ft_level_4')->nullable();
            $table->tinyInteger('gas_post_hole_auger')->nullable();
            $table->tinyInteger('granite_seal')->nullable();
            $table->tinyInteger('grass_seed')->nullable();
            $table->tinyInteger('hoe')->nullable();
            $table->tinyInteger('manual_post_hole_digger')->nullable();
            $table->tinyInteger('one_by_fours')->nullable();
            $table->tinyInteger('orange_pinch_bar')->nullable();
            $table->tinyInteger('pick_ax')->nullable();
            $table->tinyInteger('rake')->nullable();
            $table->tinyInteger('setting_dolly')->nullable();
            $table->tinyInteger('sharp_shooter_shovel')->nullable();
            $table->tinyInteger('shovel')->nullable();
            $table->tinyInteger('tamper')->nullable();
            $table->tinyInteger('two_by_fours')->nullable();
            $table->tinyInteger('two_wheel_chalks')->nullable();
            $table->tinyInteger('water_buckets_qty')->nullable();
            $table->tinyInteger('wheel_barrow')->nullable();
            $table->tinyInteger('blades')->nullable();
            $table->tinyInteger('bpx_knife_qty')->nullable();
            $table->tinyInteger('brown_silicone_qty')->nullable();
            $table->tinyInteger('caulk_gun_qty')->nullable();
            $table->tinyInteger('gray_silicone_qty')->nullable();
            $table->tinyInteger('hand_broom')->nullable();
            $table->tinyInteger('marking_paint')->nullable();
            $table->tinyInteger('masking_tape')->nullable();
            $table->tinyInteger('pry_bar')->nullable();
            $table->tinyInteger('scrapers')->nullable();
            $table->tinyInteger('scrapers1')->nullable();
            $table->tinyInteger('screw_drivers1')->nullable();
            $table->tinyInteger('string_line')->nullable();
            $table->tinyInteger('tape_measure_qty')->nullable();
            $table->tinyInteger('torpedo_level')->nullable();
            $table->tinyInteger('trowel')->nullable();
            $table->string('checker_sign')->nullable();
            $table->string('installer_sign')->nullable();

            $table->bigInteger('installation_id')->unsigned()->nullable();
            $table->foreign('installation_id')->references('id')->on('installations')->onDelete('cascade');
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
        Schema::dropIfExists('truck_load_list');
    }
}
