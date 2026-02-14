<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInProductFreightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_freights', function (Blueprint $table) {
            $table->float('freight_cost',8,2)->nullable()->after('freight_cost_per_100_lb');
            $table->string('freight_come_from')->nullable()->after('freight_cost');
            $table->float('tariff_amount',8,2)->nullable()->after('tariff_percent');
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
            $table->dropColumn('freight_cost');
            $table->dropColumn('freight_come_from');
            $table->dropColumn('tariff_amount');
        });
    }
}
