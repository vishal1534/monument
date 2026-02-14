<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersFamilyInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_family_informations', function (Blueprint $table) {
            $table->increments('order_family_information_id');
            $table->unsignedInteger('order_id')->nullable();
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->string('order_family_information_name_on_stone')->nullable();
            $table->string('order_family_information_address')->nullable();
            $table->string('order_family_information_city')->nullable();
            $table->string('order_family_information_state')->nullable();
            $table->string('order_family_information_zip')->nullable();
            $table->string('order_family_information_contact')->nullable();
            $table->string('order_family_information_phone')->nullable();
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
        Schema::dropIfExists('order_family_informations');
    }
}
