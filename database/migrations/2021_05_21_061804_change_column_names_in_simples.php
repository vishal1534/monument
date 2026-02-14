<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnNamesInSimples extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('simples', function (Blueprint $table) {
            $table->renameColumn('simple_number', 'product_number');
            $table->renameColumn('simple_name', 'item_name');
            $table->renameColumn('simple_description', 'description');
            $table->renameColumn('simple_price', 'price');
            $table->renameColumn('simple_image', 'image');
            $table->renameColumn('simple_category_id', 'category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('simples', function (Blueprint $table) {
            $table->renameColumn('product_number','simple_number');
            $table->renameColumn('item_name','simple_name');
            $table->renameColumn('description','simple_description');
            $table->renameColumn('price','simple_price');
            $table->renameColumn('image','simple_image');
        });
    }
}
