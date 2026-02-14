<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruckLoadWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_load_work_orders', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('fill_replace_add')->nullable()->comments('0 for fill, 1 for replace, 2 for add');;
            $table->date('date')->nullable();
            $table->string('day')->nullable();
            $table->date('completed_date')->nullable();
            $table->string('vehicle_name')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->string('urgency')->nullable();
            $table->string('work_order_description')->nullable();
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
        Schema::dropIfExists('truck_load_work_orders');
    }
}
