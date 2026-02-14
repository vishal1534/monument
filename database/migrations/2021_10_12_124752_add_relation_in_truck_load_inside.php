<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationInTruckLoadInside extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('truck_load_inside', function (Blueprint $table) {
            $table->bigInteger('truck_load_list_id')->unsigned()->nullable();
            $table->foreign('truck_load_list_id')->references('id')->on('truck_load_list');

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
            $table->dropForeign(['truck_load_list_id']);
            $table->dropColumn('truck_load_list_id');
        });
    }
}
