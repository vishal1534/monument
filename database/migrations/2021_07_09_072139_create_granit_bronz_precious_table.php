<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGranitBronzPreciousTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('granit_bronz_precious', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('address')->nullable();
            $table->string('family_name')->nullable();
            $table->string('horizontal_photographs')->nullable();
            $table->string('vertical_photographs')->nullable();
            $table->string('color')->nullable();
            $table->string('orientation')->nullable();
            $table->text('special_instructions')->nullable();
            $table->tinyInteger('medallion')->nullable();
            $table->tinyInteger('person_placement')->nullable();
            $table->tinyInteger('remove_background')->nullable();
            $table->tinyInteger('portrait_attached')->nullable();
            $table->string('name_on_memorial')->nullable();

            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->on('orders')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('granit_bronz_precious');
    }
}
