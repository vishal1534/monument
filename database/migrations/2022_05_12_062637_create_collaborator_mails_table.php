<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollaboratorMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collaborator_mails', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('sent_by');
            $table->string('send_to');
            $table->string('content');
            $table->tinyInteger('attachment');
            $table->unsignedBigInteger('collaboration_id');
            $table->foreign('collaboration_id')->references('id')->on('collaborations')->onDelete('cascade');
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
        Schema::dropIfExists('collaborator_mails');
    }
}
