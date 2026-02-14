<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallationCemeteryConfirmationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installation_cemetery_confirmation', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('confirm_placement_of_monument')->nullable()->default(0)->comment('Does the Cemetery need to be called to confirm PLACEMENT of Monument');
            $table->tinyInteger('different_placement')->nullable()->default(0)->comment('Is PLACEMENT different then above');
            $table->string('placement_new_information')->nullable();
            $table->tinyInteger('confirm_facing_of_monument')->nullable()->default(0)->comment('Does the Cemetery need to be called to confirm FACING of Monument');
            $table->tinyInteger('different_facing')->nullable()->default(0)->comment('Is FACING different then above');
            $table->string('facing_new_information')->nullable();

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
        Schema::dropIfExists('installation_cemetery_confirmation');
    }
}
