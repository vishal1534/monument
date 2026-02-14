<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDefaultValueOfColumnInOrderInstallations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_installations', function (Blueprint $table) {
            $table->boolean('foundation_complete')->nullable()->default(null)->change();
            $table->boolean('installation_complete')->nullable()->default(null)->change();
            $table->boolean('cemetery_called')->nullable()->default(null)->change();
            $table->boolean('grave_flagged')->nullable()->default(null)->change();
        });

        Schema::table('installation_flagging_information', function (Blueprint $table){
            $table->boolean('plot_close_to_road')->nullable()->default(null)->change();
        });

        Schema::table('installation_placements', function (Blueprint $table){
            $table->boolean('name_should_face')->nullable()->default(null)->change();
            $table->boolean('burial_type')->nullable()->default(null)->change();
            $table->boolean('currently_monuments_making_in_grave')->nullable()->default(null)->change();
        });

        Schema::table('installation_cemetery_confirmation', function (Blueprint $table){
            $table->boolean('confirm_placement_of_monument')->nullable()->default(null)->change();
            $table->boolean('different_placement')->nullable()->default(null)->change();
            $table->boolean('confirm_facing_of_monument')->nullable()->default(null)->change();
            $table->boolean('different_facing')->nullable()->default(null)->change();
        });

        Schema::table('installation_payments', function (Blueprint $table){
            $table->boolean('check_delivered')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_installations', function (Blueprint $table) {
            $table->boolean('foundation_complete')->nullable()->default(0)->change();
            $table->boolean('installation_complete')->nullable()->default(0)->change();
            $table->boolean('cemetery_called')->nullable()->default(0)->change();
            $table->boolean('grave_flagged')->nullable()->default(0)->change();
        });

        Schema::table('installation_flagging_information', function (Blueprint $table){
            $table->boolean('plot_close_to_road')->nullable()->default(0)->change();
        });

        Schema::table('installation_placements', function (Blueprint $table){
            $table->boolean('name_should_face')->nullable()->default(0)->change();
            $table->boolean('burial_type')->nullable()->default(0)->change();
            $table->boolean('currently_monuments_making_in_grave')->nullable()->default(0)->change();
        });

        Schema::table('installation_cemetery_confirmation', function (Blueprint $table){
            $table->boolean('confirm_placement_of_monument')->nullable()->default(0)->change();
            $table->boolean('different_placement')->nullable()->default(0)->change();
            $table->boolean('confirm_facing_of_monument')->nullable()->default(0)->change();
            $table->boolean('different_facing')->nullable()->default(0)->change();
        });

        Schema::table('installation_payments', function (Blueprint $table){
            $table->boolean('check_delivered')->nullable()->default(0)->change();
        });
    }
}
