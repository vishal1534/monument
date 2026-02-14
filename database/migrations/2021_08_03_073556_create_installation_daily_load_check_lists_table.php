<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallationDailyLoadCheckListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installation_daily_load_check_lists', function (Blueprint $table) {
            $table->id();
            $table->string('monument_loaded')->nullable();
            $table->string('no_of_vases')->nullable();
            $table->string('apron_cap')->nullable();
            $table->string('base_size')->nullable();
            $table->string('bags_of_concrete')->nullable();
            $table->string('sign')->nullable();

            $table->bigInteger('installer_id')->unsigned()->nullable();
            $table->foreign('installer_id')->references('id')->on('installers');

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
        Schema::dropIfExists('installation_daily_load_check_lists');
    }
}
