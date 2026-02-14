<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simples', function (Blueprint $table) {
            $table->id();
            $table->string('simple_number')->nullable();
            $table->string('simple_name')->nullable();
            $table->float('simple_price')->nullable()->default(0);
            $table->string('simple_image')->nullable();
            $table->string('simple_description')->nullable();
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
        Schema::dropIfExists('simples');
    }
}
