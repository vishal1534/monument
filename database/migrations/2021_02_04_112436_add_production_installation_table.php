<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductionInstallationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_installations', function (Blueprint $table) {
            $table->increments('production_installation_id');
            $table->string('production_installation_who')->nullable();
            $table->string('production_installation_where')->nullable();
            $table->string('production_installation_cemetery_amount')->nullable();
            $table->string('production_installation_cemetery_paid')->nullable();
            $table->string('production_installation_cemetery_called_to_flag')->nullable();
            $table->string('production_installation_grave_flagged')->nullable();
            $table->string('production_installation_cemetery_take')->nullable();
            $table->string('production_installation_zone')->nullable();
            $table->date('production_installation_date_promised')->nullable();
            $table->string('production_installation_foundation_done')->nullable();
            $table->string('production_installation_set_stone')->nullable();
            $table->date('production_installation_install_date')->nullable();
            $table->string('production_installation_customer_called_after_install')->nullable();
            $table->text('production_installation_memo')->nullable();
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
        Schema::dropIfExists('production_installations');

    }
}
