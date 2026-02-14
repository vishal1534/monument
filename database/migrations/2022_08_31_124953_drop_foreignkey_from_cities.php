<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropForeignkeyFromCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->unsignedBigInteger('state_id')->nullable()->after('city_title');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
            $table->unsignedBigInteger('county_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropForeign(['state_id']);
            $table->dropColumn("state_id");
            $table->unsignedBigInteger('county_id')->change();
        });
    }
}
