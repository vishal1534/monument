<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monuments', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->string('item_name', 255)->nullable();
            $table->float('cost')->default(0)->nullable();
            $table->integer('total_on_hand')->nullable();
            $table->integer('total_sold')->nullable();
            $table->integer('quantity_stocked')->nullable();
            $table->integer('total_added')->nullable();
            $table->string('description',255)->nullable();
            $table->float('selling_formula')->default(1)->nullable();
            $table->bigInteger('color_id')->unsigned()->nullable();
            $table->bigInteger('shape_id')->unsigned()->nullable();
            $table->bigInteger('type_id')->unsigned()->nullable();
            $table->bigInteger('side_id')->unsigned()->nullable();
            $table->foreign('color_id')->references('id')->on('product_colors');
            $table->foreign('shape_id')->references('id')->on('product_shapes');
            $table->foreign('type_id')->references('id')->on('product_types');
            $table->foreign('side_id')->references('id')->on('product_sides');
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
        Schema::dropIfExists('monuments');
    }
}
