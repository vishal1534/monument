<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryRelationInProductFrieghts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_freights', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->after('monument_id')->nullable();
            $table->foreign('country_id','country_freight_ids_foreign')->references('id')->on('countries')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_freights', function (Blueprint $table) {
            $table->dropForeign('country_freight_ids_foreign');
        });
    }
}
