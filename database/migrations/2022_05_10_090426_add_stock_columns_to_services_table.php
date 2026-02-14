<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStockColumnsToServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->integer('total_on_hand')->nullable()->after('product_cost');
            $table->integer('total_sold')->nullable()->after('product_cost');
            $table->integer('quantity_stocked')->nullable()->after('product_cost');
            $table->integer('quantity_backordered')->nullable()->after('product_cost');
            $table->integer('total_added')->nullable()->after('product_cost');
            $table->string('stock_info')->nullable()->after('product_cost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['total_on_hand','total_sold','quantity_stocked','quantity_backordered','total_added','stock_info']);
        });
    }
}
