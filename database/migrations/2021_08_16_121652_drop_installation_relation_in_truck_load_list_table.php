<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropInstallationRelationInTruckLoadListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('truck_load_list', function (Blueprint $table) {
            $table->dropForeign(['installation_id']);
            $table->dropColumn('installation_id');
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
