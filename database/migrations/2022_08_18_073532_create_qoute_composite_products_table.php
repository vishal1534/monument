<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQouteCompositeProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_composite_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->integer('quantity')->default(0)->nullable();
            $table->float('price', 8,2)->default(0)->nullable();
            $table->float('price_override',8,2)->default(0)->nullable();
            $table->float('computer_selling_price',8,2)->default(0)->nullable();
            $table->float('installation_price',8,2)->default(0)->nullable();
            $table->tinyInteger('installation')->default(0)->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qoute_composite_products');
    }
}
