<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyInCemeteries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cemeteries', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('city_id')->change();
            $table->foreign('city_id','cemetery_city_id_foreign')->references('id')->on('cities')->onDelete('cascade');
            $table->unsignedBigInteger('county_id')->change();
            $table->foreign('county_id','cemetery_county_id_foreign')->references('id')->on('counties')->onDelete('cascade');
            $table->unsignedBigInteger('state_id')->change();
            $table->foreign('state_id','cemetery_state_id_foreign')->references('id')->on('states')->onDelete('cascade');
            $table->unsignedBigInteger('cemetery_category_id')->change();
            $table->foreign('cemetery_category_id','cemetery_category_id_foreign')->references('id')->on('cemetery_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cemeteries', function (Blueprint $table) {
            $table->dropForeign('cemetery_city_id_foreign');
            $table->dropForeign('cemetery_county_id_foreign');
            $table->dropForeign('cemetery_state_id_foreign');
            $table->dropForeign('cemetery_category_id_foreign');
        });
    }
}
