<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('productable_id')->nullable();
            $table->string('productable_type')->nullable();
            $table->bigInteger('quote_id')->unsigned()->nullable();
            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->integer('quantity')->default(0)->nullable();
            $table->integer('amount')->default(0)->nullable();
            $table->float('price',8,2)->default(0)->nullable();
            $table->float('client_price',8,2)->default(0)->nullable();
            $table->float('installation_price',8,2)->default(0)->nullable();
            $table->float('total',8,2)->default(0)->nullable();
            $table->foreign('quote_id')->references('id')->on('quotes');
//            $table->foreign('order_id')->references('id')->on('orders');
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
        Schema::dropIfExists('products');
    }
}
