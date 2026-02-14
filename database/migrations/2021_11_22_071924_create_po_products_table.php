<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_products', function (Blueprint $table) {
            $table->id();
            $table->double('quantity')->nullable();
            $table->double('cost')->nullable();
            $table->double('amount')->nullable();
            $table->double('unit_weight')->nullable();
            $table->double('total_weight')->nullable();
            $table->string('notes')->nullable();
            $table->tinyInteger('posted')->nullable();
            $table->unsignedBigInteger('po_order_id')->nullable();
            $table->foreign('po_order_id')->references('id')->on('po_orders')->onDelete('set null');
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
        Schema::dropIfExists('po_products');
    }
}
