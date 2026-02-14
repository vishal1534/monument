<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderBricksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_bricks', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('first_address');
            $table->string('first_phone');
            $table->string('second_name');
            $table->string('second_address');
            $table->string('second_phone');
            $table->string('approved_by');
            $table->string('date');

            $table->bigInteger('order_id')->unsigned()->nullable();
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
        Schema::dropIfExists('order_bricks');
    }
}
