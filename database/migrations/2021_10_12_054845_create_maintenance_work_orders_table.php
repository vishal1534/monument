<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_work_orders', function (Blueprint $table) {
            $table->id();
            $table->string("equipment")->nullable();
            $table->string("location")->nullable();
            $table->string("department")->nullable();
            $table->string("type_of_repair")->nullable();
            $table->string("urgency")->nullable();
            $table->longText("description_of_problem")->nullable();
            $table->string("person_assigned")->nullable();
            $table->dateTime("perform_work_order")->nullable();
            $table->string("estimated_man_hours")->nullable();
            $table->string("actual_man_hours")->nullable();
            $table->dateTime("work_order_completed")->nullable();
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
        Schema::dropIfExists('maintenance_work_orders');
    }
}
