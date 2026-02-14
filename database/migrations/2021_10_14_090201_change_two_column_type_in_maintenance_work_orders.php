<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTwoColumnTypeInMaintenanceWorkOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maintenance_work_orders', function (Blueprint $table) {
            $table->date("added_date")->nullable()->after("perform_work_order");
            $table->string("person_requesting")->nullable()->after("person_assigned");
            $table->date("perform_work_order")->nullable()->change();
            $table->date("work_order_completed")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('maintenance_work_orders', function (Blueprint $table) {
            $table->dropColumn("added_date");
            $table->dropColumn("person_requesting");
            $table->dateTime("perform_work_order");
            $table->dateTime("work_order_completed");
        });
    }
}
