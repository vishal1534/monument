<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTypeColumnFromGranitBronzPreciousSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('granit_bronz_precious_specifications', function (Blueprint $table) {
            $table->dropForeign('mps_granit_bronz_precious_specifications_gbp_id_foreign');
            $table->dropColumn('gbp_id');
            $table->dropColumn('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('granit_bronz_precious_specifications', function (Blueprint $table) {
            $table->string('type')->nullable();
            $table->bigInteger('gbp_id')->unsigned()->nullable();
            $table->foreign('gbp_id')->on('granit_bronz_precious')->references('id');
        });
    }
}
