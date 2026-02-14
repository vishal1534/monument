<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompositeProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('composite_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('composite_id')->unsigned()->nullable();
            $table->integer('quantity')->default(0)->nullable();
            $table->float('cost',8,2)->default(0)->nullable();
            $table->float('price_override',8,2)->default(0)->nullable();
            $table->float('computer_selling_price',8,2)->default(0)->nullable();
            $table->float('installation_price',8,2)->default(0)->nullable();
            $table->tinyInteger('installation')->default(0)->nullable();
            $table->foreign('composite_id')->references('id')->on('composites');
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
        Schema::dropIfExists('composite_products');
    }
}
