<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFreightAmountColumnInProductFreights extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_freights', function (Blueprint $table) {
            $table->string('freight_amount')->after('freight_cost_per_100_lb')->nullable();
            $table->string('tariff_percent')->after('freight_amount')->nullable();
            $table->string('freight_cost_per_100_lb')->nullable()->change();
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
            $table->dropColumn('freight_amount');
            $table->dropColumn('tariff_percent');
        });
    }
}
