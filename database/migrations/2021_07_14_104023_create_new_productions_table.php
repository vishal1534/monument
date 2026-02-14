<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->string('monument_in_stock')->nullable();
            $table->string('on_order_who')->nullable();
            $table->string('order_who_vendor_proof')->nullable();
            $table->string('on_order_in_stock')->nullable();
            $table->string('picture_who')->nullable();
            $table->string('picture_who_vendor_proof')->nullable();
            $table->string('picture_in_stock')->nullable();
            $table->string('vase_who')->nullable();
            $table->string('vase_in_stock')->nullable();
            $table->string('access_who')->nullable();
            $table->string('access_in_stock')->nullable();
            $table->string('rubbing_need')->nullable();
            $table->string('design_in_house')->nullable();
            $table->string('design_customer')->nullable();
            $table->string('cemetery_approval_needed')->nullable();
            $table->string('install_from_cemetery')->nullable();
            $table->string('temp_maker_who')->nullable();
            $table->string('temp_maker_in_stock')->nullable();
            $table->date('final_date')->nullable();
            $table->string('porcelain_made')->nullable();
            $table->string('monument_make')->nullable();
            $table->string('paid')->nullable();
            $table->string('blast_who')->nullable();
            $table->string('stencial')->nullable();
            $table->string('blast_complete')->nullable();
            $table->string('etch_who')->nullable();
            $table->string('etch_complete')->nullable();
            $table->string('picture_mounted')->nullable();
            $table->string('access_mounted')->nullable();
            $table->string('special_install_instructions')->nullable();

            $table->bigInteger('order_id')->unsigned()-> nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
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
        Schema::dropIfExists('productions');
    }
}
