<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallationProductionListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installation_production_list', function (Blueprint $table) {
            $table->id();
            $table->string('size_of_base')->nullable();
            $table->string('total_sq_ft')->nullable();
            $table->date('date')->nullable();
            $table->string('initials')->nullable();

            $table->bigInteger('install_production_id')->unsigned()->nullable();
            $table->foreign('install_production_id')->references('id')->on('installation_productions')->onDelete('cascade');
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
        Schema::dropIfExists('installation_production_list');
    }
}
