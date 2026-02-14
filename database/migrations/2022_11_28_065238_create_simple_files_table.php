<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimpleFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simple_files', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('file')->nullable();
            $table->unsignedBigInteger('simple_id')->nullable();
            $table->foreign('simple_id')->references('id')->on('simples')->onDelete('set null');
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
        Schema::dropIfExists('simple_files');
    }
}
