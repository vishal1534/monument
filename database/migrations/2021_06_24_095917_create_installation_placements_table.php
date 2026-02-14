<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallationPlacementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installation_placements', function (Blueprint $table) {
            $table->id();
            $table->string('female_buried_direction')->nullable();
            $table->string('male_buried_direction')->nullable();
            $table->tinyInteger('name_should_face')->nullable()->default(0)->comment('options: 0. The grave, 1. away from grave');
            $table->string('graves_monument_going_over')->nullable()->comment('in percentage(%)');
            $table->tinyInteger('burial_type')->nullable()->default(0)->comment('options: 0. Traditional, 1. Cremation, 2. Pre-Need');
            $table->string('burial_details')->nullable();
            $table->tinyInteger('currently_monuments_making_in_grave')->nullable()->default(0);
            $table->string('special_notes')->nullable();
            $table->date('placement_date')->nullable();

            $table->bigInteger('installation_id')->unsigned()->nullable();
            $table->foreign('installation_id')->references('id')->on('order_installations')->onDelete('cascade');
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
        Schema::dropIfExists('installation_placements');
    }
}
