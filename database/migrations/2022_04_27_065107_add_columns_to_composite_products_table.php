<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCompositeProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('composite_products', function (Blueprint $table) {
           /* $table->integer('on_hand')->nullable()->after('installation');
            $table->integer('quantity_stocked')->nullable()->after('installation');
            $table->integer('weight')->nullable()->after('installation');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('composite_products', function (Blueprint $table) {
          //  $table->dropColumn(['on_hand', 'quantity_stocked', 'weight']);
        });
    }
}
