<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionOcPictureListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_oc_picture_list', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->nullable();
            $table->string('last_name')->nullable();
            $table->string('size_of_photo')->nullable();
            $table->string('complete')->nullable();
            $table->date('date')->nullable();
            $table->string('initials')->nullable();

            $table->bigInteger('production_oc_picture_id')->unsigned()->nullable();
            $table->foreign('production_oc_picture_id')->references('id')->on('production_oc_pictures');
            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->references('id')->on('orders');
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
        Schema::dropIfExists('production_oc_picture_list');
    }
}
