<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompositeInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('composite_inventories', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date')->nullable();
            $table->string('by_whom')->nullable();
            $table->unsignedBigInteger('invoice_number')->nullable();
            $table->foreign('invoice_number')->references('invoice_number')->on('invoices')->onDelete('cascade');
            $table->string('item_order')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedBigInteger('composite_id')->nullable();
            $table->foreign('composite_id')->references('id')->on('composites')->onDelete('cascade');
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
        Schema::dropIfExists('composite_inventories');
    }
}
