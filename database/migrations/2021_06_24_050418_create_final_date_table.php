<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinalDateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_date', function (Blueprint $table) {
            $table->id();
            $table->string('contact')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('cemetery_details')->nullable();
            $table->string('name_on_stone')->nullable();
            $table->string('engraving_for')->nullable();
            $table->dateTime('birth_date')->nullable();
            $table->dateTime('final_date')->nullable();
            $table->tinyInteger('final_type')->nullable();
            $table->string('scroll_length')->nullable();
            $table->string('scroll_width')->nullable();
            $table->string('drill_points')->nullable();
            $table->tinyInteger('rubbing_needed')->nullable();
            $table->dateTime('rubbing_date')->nullable();
            $table->string('stone_description')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('date_on_completion')->nullable();
            $table->string('completed_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->dateTime('date')->nullable();
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
        Schema::dropIfExists('final_date');
    }
}
