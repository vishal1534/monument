<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceColumnsInMonumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monuments', function (Blueprint $table) {
            $table->float('special_shape_cost',8,2)->nullable()->default(0)->after('description');
            $table->float('cost',8,2)->nullable()->default(0)->after('special_shape_cost');
            $table->float('total_cost_with_freight',8,2)->nullable()->default(0)->after('cost');
            $table->float('selling_price',8,2)->nullable()->default(0)->after('selling_formula');
            $table->float('selling_price_with_installation',8,2)->nullable()->default(0)->after('selling_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monuments', function (Blueprint $table) {
            $table->dropColumn('special_shape_cost');
            $table->dropColumn('cost');
            $table->dropColumn('total_cost_with_freight');
            $table->dropColumn('selling_price');
            $table->dropColumn('selling_price_with_installation');
        });
    }
}
