<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePorcelainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('porcelains', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('photograph')->nullable()->comment('0 is color, 1 is black & white, 2 is sepia brown');
            $table->tinyInteger('border')->nullable()->comment('0 is black border, 1 is no border, 2 is white border');
            $table->tinyInteger('background')->nullable()->comment('0 is other , 1 is keep same background');
            $table->text('special_instructions')->nullable();
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
        Schema::dropIfExists('porcelains');
    }
}
