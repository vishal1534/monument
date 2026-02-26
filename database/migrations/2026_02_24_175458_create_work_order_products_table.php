<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->bigInteger('work_order_id')->unsigned()->nullable();
            $table->string('item_name', 255)->nullable();
            $table->string('type', 255)->nullable();
            $table->string('product_type', 255)->nullable();
            $table->string('product_number', 255)->nullable();
            $table->float('price')->default(0)->nullable();
            $table->integer('quantity')->default(0)->nullable();
            $table->float('total')->default(0)->nullable();
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
        Schema::dropIfExists('work_order_products');
    }
}
