<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGranitBronzPreciousSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('granit_bronz_precious_specifications', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('oval_0')->nullable();
            $table->tinyInteger('oval_1')->nullable();
            $table->tinyInteger('oval_2')->nullable();
            $table->tinyInteger('oval_3')->nullable();
            $table->tinyInteger('oval_4')->nullable();
            $table->tinyInteger('oval_5')->nullable();
            $table->tinyInteger('rectangular_0')->nullable();
            $table->tinyInteger('rectangular_1')->nullable();
            $table->tinyInteger('rectangular_2')->nullable();
            $table->tinyInteger('rectangular_3')->nullable();
            $table->tinyInteger('heart_0')->nullable();
            $table->tinyInteger('heart_1')->nullable();
            $table->tinyInteger('round_0')->nullable();
            $table->tinyInteger('round_1')->nullable();
            $table->string('type')->nullable();

            $table->bigInteger('gbp_id')->unsigned()->nullable();
            $table->foreign('gbp_id')->on('granit_bronz_precious')->references('id');

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
        Schema::dropIfExists('granit_bronz_precious_specifications');
    }
}
