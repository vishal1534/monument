<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallationMonumentInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installation_monument_information', function (Blueprint $table) {
            $table->id();
            $table->string('tablet_slant_grasser')->nullable();
            $table->string('base')->nullable();
            $table->string('apron_cap')->nullable();
            $table->string('vases')->nullable();
            $table->string('accessories')->nullable();

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
        Schema::dropIfExists('installation_monument_information');
    }
}
