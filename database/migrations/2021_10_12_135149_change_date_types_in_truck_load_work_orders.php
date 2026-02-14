<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDateTypesInTruckLoadWorkOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('truck_load_work_orders', function (Blueprint $table) {
            $table->string('date')->change();
            $table->string('completed_date')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('truck_load_work_orders', function (Blueprint $table) {
            $table->date('date')->change();
            $table->date('completed_date')->change();
        });
    }
}
