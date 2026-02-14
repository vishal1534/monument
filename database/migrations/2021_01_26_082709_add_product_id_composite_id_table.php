<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdCompositeIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('composites_products', function (Blueprint $table) {
//            $table->foreignId('product_id')->after('id')->constrained('products');
//            $table->foreignId('composite_id')->after('product_id')->constrained('composites');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('composites_products', function (Blueprint $table) {
//            $table->dropForeign('composites_products_composite_id_foreign');
//            $table->dropForeign('composites_products_product_id_foreign');
//
//        });
    }
}
