<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCemeteryFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cemetery_files', function (Blueprint $table) {
            $table->id();
            $table->string('file')->nullable();
            $table->unsignedBigInteger('cemetery_id')->nullable();
            $table->foreign('cemetery_id')->references('id')->on('cemeteries')->onDelete('CASCADE');
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
        Schema::dropIfExists('cemetery_files');
    }
}
