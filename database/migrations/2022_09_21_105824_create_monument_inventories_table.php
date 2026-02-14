<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonumentInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monument_inventories', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date')->nullable();
            $table->string('total')->nullable();
            $table->string('qty_add_or_remove')->default(0);
            $table->string('by_whom')->nullable();
            $table->string('item_order')->nullable();
            $table->unsignedBigInteger('monument_id');
            $table->foreign('monument_id')->references('id')->on('monuments')->onDelete('cascade');
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
        Schema::dropIfExists('monument_inventories');
    }
}
