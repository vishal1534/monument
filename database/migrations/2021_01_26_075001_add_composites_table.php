<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompositesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('composites', function (Blueprint $table) {
            $table->id();
            $table->string('composite_name')->nullable();
            $table->float('composite_cost')->default(0);
            $table->integer('composite_inventory')->default(0);
            $table->integer('composite_sold')->default(0);
            $table->integer('composite_on_hand')->default(0);
            $table->string('composite_description')->nullable();
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
        Schema::dropIfExists('composites');
    }
}
