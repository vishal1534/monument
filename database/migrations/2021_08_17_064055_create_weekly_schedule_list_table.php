<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeeklyScheduleListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly_schedule_list', function (Blueprint $table) {
            $table->id();

            $table->date('day')->nullable();
            $table->string('person')->nullable();
            $table->string('cemetery')->nullable();
            $table->string('monument_name')->nullable();
            $table->string('special_notes')->nullable();
            $table->tinyInteger('approved')->nullable();
            $table->string('zone')->nullable();

            $table->bigInteger('weekly_schedule_id')->unsigned()->nullable();
            $table->foreign('weekly_schedule_id')->references('id')->on('weekly_schedules')->onDelete('cascade');
            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->references('id')->on('orders');

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
        Schema::dropIfExists('weekly_schedule_list');
    }
}
