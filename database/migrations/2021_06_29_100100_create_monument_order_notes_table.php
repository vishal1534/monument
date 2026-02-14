<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonumentOrderNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monument_order_notes', function (Blueprint $table) {
            $table->id();
            $table->text('note_1')->nullable();
            $table->text('note_2')->nullable();
            $table->text('note_3')->nullable();
            $table->text('note_4')->nullable();
            $table->text('note_5')->nullable();
            $table->text('note_6')->nullable();
            $table->text('note_7')->nullable();
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
        Schema::dropIfExists('monument_order_notes');
    }
}
