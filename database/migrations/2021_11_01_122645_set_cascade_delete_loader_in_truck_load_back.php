<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetCascadeDeleteLoaderInTruckLoadBack extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('truck_load_back', function (Blueprint $table) {
            $table->dropForeign(['setting_dolly_id']);
            $table->foreign('setting_dolly_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['granite_seal_id']);
            $table->foreign('granite_seal_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['shovel_id']);
            $table->foreign('shovel_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['sharp_shooter_shovel_id']);
            $table->foreign('sharp_shooter_shovel_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['hoe_id']);
            $table->foreign('hoe_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['rake_id']);
            $table->foreign('rake_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['pick_ax_id']);
            $table->foreign('pick_ax_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['ft_level_4_id']);
            $table->foreign('ft_level_4_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['manual_post_hole_digger_id']);
            $table->foreign('manual_post_hole_digger_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['gas_post_hole_auger_id']);
            $table->foreign('gas_post_hole_auger_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['dingo_roller_bar_id']);
            $table->foreign('dingo_roller_bar_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['crane_roller_bar_id']);
            $table->foreign('crane_roller_bar_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['tamper_id']);
            $table->foreign('tamper_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['wheel_barrow_id']);
            $table->foreign('wheel_barrow_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['orange_pinch_bar_id']);
            $table->foreign('orange_pinch_bar_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['blue_roller_id']);
            $table->foreign('blue_roller_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['two_wheel_chalks_id']);
            $table->foreign('two_wheel_chalks_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['water_buckets_id']);
            $table->foreign('water_buckets_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['two_by_fours_id']);
            $table->foreign('two_by_fours_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['one_by_fours_id']);
            $table->foreign('one_by_fours_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['grass_seed_id']);
            $table->foreign('grass_seed_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['bucket_pea_gravel_id']);
            $table->foreign('bucket_pea_gravel_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
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
        Schema::table('truck_load_back', function (Blueprint $table) {
            //
        });
    }
}
