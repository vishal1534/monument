<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductionCorrespondenceTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_correspondence_tasks', function (Blueprint $table) {
            $table->increments('production_correspondence_task_id');
            $table->date('production_correspondence_task_date')->nullable();
            $table->string('production_correspondence_task_who_corsp')->nullable();
            $table->string('production_correspondence_task_form_of_communication')->nullable();
            $table->string('production_correspondence_task_why_called')->nullable();
            $table->string('production_correspondence_task_reasons_from_customer')->nullable();
            $table->string('production_correspondence_task_notes')->nullable();
            $table->string('production_correspondence_task_name_of_contact')->nullable();

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
        Schema::dropIfExists('production_correspondence_tasks');
    }
}
