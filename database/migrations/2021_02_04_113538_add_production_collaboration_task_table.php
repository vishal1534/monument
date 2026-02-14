<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductionCollaborationTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_collaboration_tasks', function (Blueprint $table) {
            $table->increments('production_collaboration_task_id');
            $table->date('production_collaboration_task_date')->nullable();
            $table->string('production_collaboration_task_assigned_to')->nullable();
            $table->string('production_collaboration_task_what_to_do')->nullable();
            $table->string('production_collaboration_task_dept')->nullable();
            $table->date('production_collaboration_closed_date')->nullable();
            $table->string('production_collaboration_created_by')->nullable();
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
        Schema::dropIfExists('production_collaboration_tasks');
    }
}
