<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePriceTypeInProductPolishes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_polishes', function (Blueprint $table) {
            $table->float('polish_linear_cost_per_feet')->change();
            $table->float('price')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_polishes', function (Blueprint $table) {
            //
        });
    }
}
