<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceColumnsInComposites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('composites', function (Blueprint $table) {
            $table->float('composite_retail_price')->after('composite_description')->nullable();
            $table->float('composite_install_price')->after('composite_retail_price')->nullable();
            $table->float('composite_final_price')->after('composite_install_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('composites', function (Blueprint $table) {
            $table->dropColumn('composite_retail_price');
            $table->dropColumn('composite_install_price');
            $table->dropColumn('composite_final_price');
        });
    }
}
