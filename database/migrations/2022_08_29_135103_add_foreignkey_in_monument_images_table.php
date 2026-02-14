<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignkeyInMonumentImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monument_images', function (Blueprint $table){
            $table->id();
            $table->string('file')->nullable();
            $table->unsignedBigInteger('monument_id')->nullable();
            $table->foreign('monument_id')->references('id')->on('monuments')->onDelete('CASCADE');
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
        Schema::dropIfExists('monument_images');
    }
}
