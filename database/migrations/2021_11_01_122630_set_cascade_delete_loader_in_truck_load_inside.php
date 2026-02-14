<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetCascadeDeleteLoaderInTruckLoadInside extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('truck_load_inside', function (Blueprint $table) {
            $table->dropForeign(['black_blankets_id']);
            $table->foreign('black_blankets_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['rubbing_paper_id']);
            $table->foreign('rubbing_paper_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['jumper_cabels_id']);
            $table->foreign('jumper_cabels_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['emergency_stuff_id']);
            $table->foreign('emergency_stuff_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['fire_ext_id']);
            $table->foreign('fire_ext_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['probe_id']);
            $table->foreign('probe_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['install_check_list_id']);
            $table->foreign('install_check_list_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['marking_pencil_wax_id']);
            $table->foreign('marking_pencil_wax_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['gray_tarp_id']);
            $table->foreign('gray_tarp_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['tire_repair_kit_id']);
            $table->foreign('tire_repair_kit_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['bag_for_dirt_id']);
            $table->foreign('bag_for_dirt_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
            $table->dropForeign(['monument_tags_cards_id']);
            $table->foreign('monument_tags_cards_id')->references('id')->on('truck_load_work_orders')->onDelete('cascade');
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
        Schema::table('truck_load_inside', function (Blueprint $table) {
            //
        });
    }
}
