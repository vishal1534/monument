<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallationFlaggingInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installation_flagging_information', function (Blueprint $table) {
            $table->id();
            $table->string('block_number')->nullable();
            $table->string('lot_number')->nullable();
            $table->string('section')->nullable();
            $table->string('plot_grave_number')->nullable();
            $table->string('grave_marked_out')->nullable();
            $table->string('grave_location')->nullable();
            $table->tinyInteger('plot_close_to_road')->nullable()->default(0);
            $table->string('special_notes')->nullable();

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
        Schema::dropIfExists('installation_flagging_information');
    }
}
