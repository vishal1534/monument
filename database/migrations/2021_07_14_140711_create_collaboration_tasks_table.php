<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollaborationTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collaboration_tasks', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->date('close_date')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('task')->nullable();
            $table->string('dept')->nullable();
            $table->string('created_by')->nullable();
            $table->string('status')->nullable();

            $table->bigInteger('collaboration_id')->unsigned()->nullable();
            $table->foreign('collaboration_id')->references('id')->on('collaborations')->onDelete('cascade');
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
        Schema::dropIfExists('collaboration_tasks');
    }
}
