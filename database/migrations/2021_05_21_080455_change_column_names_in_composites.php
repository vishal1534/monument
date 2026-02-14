<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnNamesInComposites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('composites', function (Blueprint $table) {
            $table->renameColumn('composite_number','product_number');
            $table->renameColumn('composite_name','item_name');
            $table->renameColumn('composite_description','description');
            $table->renameColumn('composite_image','image');
            $table->renameColumn('composite_cost','price');
            $table->renameColumn('composite_on_hand','on_hand');
            $table->renameColumn('composite_added','added');
            $table->renameColumn('composite_sold','sold');
            $table->renameColumn('composite_inventory','stocked');
            $table->renameColumn('composite_retail_price','retail_price');
            $table->renameColumn('composite_install_price','install_price');
            $table->renameColumn('composite_final_price','final_price');
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

            $table->renameColumn('product_number','composite_number');
            $table->renameColumn('item_name','composite_name');
            $table->renameColumn('description','composite_description');
            $table->renameColumn('image','composite_image');
            $table->renameColumn('price','composite_cost');
            $table->renameColumn('on_hand','composite_on_hand');
            $table->renameColumn('added','composite_added');
            $table->renameColumn('sold','composite_sold');
            $table->renameColumn('stocked','composite_inventory');
            $table->renameColumn('retail_price','composite_retail_price');
            $table->renameColumn('install_price','composite_install_price');
            $table->renameColumn('final_price','composite_final_price');
        });
    }
}
