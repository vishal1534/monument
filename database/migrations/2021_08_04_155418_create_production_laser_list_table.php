<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionLaserListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_laser_list', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->nullable();
            $table->string('last_name')->nullable();
            $table->string('size_of_die')->nullable();
            $table->string('total_sq_ft')->nullable();
            $table->date('date')->nullable();
            $table->string('initials')->nullable();

            $table->bigInteger('laser_id')->unsigned()->nullable();
            $table->foreign('laser_id')->references('id')->on('production_lasers');
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
        Schema::dropIfExists('production_laser_list');
    }
}
