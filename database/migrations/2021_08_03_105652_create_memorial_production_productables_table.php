<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemorialProductionProductablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memorial_production_productables', function (Blueprint $table) {
            $table->id();
            $table->integer('memorial_production_product_id');
            $table->integer('memorial_production_productable_id');
            $table->string('memorial_production_productable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memorial_production_productables');
    }
}
