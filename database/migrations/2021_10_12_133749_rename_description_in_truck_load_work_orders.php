<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameDescriptionInTruckLoadWorkOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('truck_load_work_orders', function (Blueprint $table) {
            $table->renameColumn('work_order_description','description');
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
            $table->renameColumn('description','work_order_description');
        });
    }
}
