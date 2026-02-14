<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompositeFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('composite_files', function (Blueprint $table) {
            $table->id();
            $table->string('file')->nullable();
            $table->unsignedBigInteger('composite_id')->nullable();
            $table->foreign('composite_id')->references('id')->on('composites')->onDelete('set null');
            $table->timestamps();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('composite_files');
    }
}
