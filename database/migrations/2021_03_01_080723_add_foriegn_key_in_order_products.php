<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForiegnKeyInOrderProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_products', function (Blueprint $table) {
            //
//            $table->unsignedInteger('order_id')->after('order_product_installation')->nullable();
//            $table->foreign('order_id','order_products_order_id_foreign')->references('order_id')->on('orders')->onDelete('cascade');

//            $table->unsignedBigInteger('product_id')->after('order_id')->nullable();
//            $table->foreign('product_id','order_products_product_id_foreign')->references('id')->on('products')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_products', function (Blueprint $table) {
            //
//            $table->dropForeign([
//                'order_products_order_id_foreign',
//                'order_products_product_id_foreign'
//            ]);
        });
    }
}
