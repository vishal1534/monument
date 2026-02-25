<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrderCollaborationTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_collaboration_tasks', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->date('close_date')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('task')->nullable();
            $table->string('created_by')->nullable();
            $table->string('status')->nullable();

            $table->bigInteger('work_order_id')->unsigned()->nullable();
            $table->foreign('work_order_id')->references('id')->on('maintenance_work_orders')->onDelete('cascade');

            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');

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
        Schema::dropIfExists('work_order_collaboration_tasks');
    }
}
