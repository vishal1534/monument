<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetCascadeDeleteLoaderInTruckLoadPassenger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('truck_load_passenger', function (Blueprint $table) {
            $table->dropForeign(['ratchet_srtap_qty11_id']);
            $table->foreign('ratchet_srtap_qty11_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['red_setting_cushions_id']);
            $table->foreign('red_setting_cushions_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['white_setting_cushions_id']);
            $table->foreign('white_setting_cushions_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['roll_blue_paper_towels_id']);
            $table->foreign('roll_blue_paper_towels_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['black_rubber_monument_pads_id']);
            $table->foreign('black_rubber_monument_pads_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['screw_drivers_id']);
            $table->foreign('screw_drivers_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['pliers_id']);
            $table->foreign('pliers_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['box_knife_id']);
            $table->foreign('box_knife_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['tape_id']);
            $table->foreign('tape_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['tubes_gray_silicone_id']);
            $table->foreign('tubes_gray_silicone_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['squirt_bottle_coleman_full_id']);
            $table->foreign('squirt_bottle_coleman_full_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['scrub_bush_id']);
            $table->foreign('scrub_bush_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['spray_bottle_windex_id']);
            $table->foreign('spray_bottle_windex_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['ft_level2_id']);
            $table->foreign('ft_level2_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
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
        Schema::table('truck_load_passenger', function (Blueprint $table) {
            //
        });
    }
}
