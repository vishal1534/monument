<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('products', function (Blueprint $table) {
//            $table->dropForeign('mps_products_category_id_foreign');
//        });
//        Schema::table('composites_products', function (Blueprint $table) {
//            $table->dropForeign('mps_composites_products_product_id_foreign');
//        });
//        Schema::table('order_products', function (Blueprint $table) {
//            $table->dropForeign('order_products_product_id_foreign');
//        });
//        Schema::dropIfExists('products');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
