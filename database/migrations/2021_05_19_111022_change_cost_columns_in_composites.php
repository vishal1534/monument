<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCostColumnsInComposites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('composites', function (Blueprint $table) {
            $table->float('composite_cost')->nullable()->change();
            $table->integer('composite_inventory')->nullable()->change();
            $table->integer('composite_on_hand')->nullable()->change();
            $table->integer('composite_added')->nullable()->change();
            $table->integer('composite_sold')->nullable()->change();
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
            $table->float('composite_cost')->nullable(false)->change();
            $table->integer('composite_inventory')->nullable(false)->change();
            $table->integer('composite_on_hand')->nullable(false)->change();
            $table->integer('composite_added')->nullable(false)->change();
            $table->integer('composite_sold')->nullable(false)->change();
        });
    }
}
