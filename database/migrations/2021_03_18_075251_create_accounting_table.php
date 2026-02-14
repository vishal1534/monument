<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting', function (Blueprint $table) {
            $table->id();
            $table->string("material")->nullable();
            $table->string("material_installation_labour_cemt")->nullable();
            $table->string("dealer")->nullable();
            $table->string("material_shipping")->nullable();
            $table->string("total_material")->nullable();
            $table->string("o_e")->nullable();
            $table->string("o_e_labour_shop_install")->nullable();
            $table->string("total_o_e")->nullable();
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
        Schema::dropIfExists('accounting');
    }
}
