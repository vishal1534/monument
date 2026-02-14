<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorrespondenceTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correspondence_tasks', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('who_corsp')->nullable();
            $table->string('form_of_communication')->nullable();
            $table->string('why_contacted')->nullable();
            $table->string('customer_reasons')->nullable();
            $table->string('notes')->nullable();
            $table->string('contact_name')->nullable();

            $table->bigInteger('correspondence_id')->unsigned()->nullable();
            $table->foreign('correspondence_id')->references('id')->on('correspondences')->onDelete('cascade');
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
        Schema::dropIfExists('corresponding_tasks');
    }
}
