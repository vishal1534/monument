<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostPSqureFeetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_p_squre_feets', function (Blueprint $table) {
            $table->id();
            $table->string('cost_color')->nullable();
            $table->string('cost_type')->nullable();
            $table->string('granite_thickness')->nullable();
            $table->string('granite_sq_ft_price')->nullable();
            $table->string('granite_description')->nullable();
            $table->string('cost_vendor')->nullable();
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
        Schema::dropIfExists('cost_p_squre_feets');
    }
}
