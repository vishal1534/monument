<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrderCollaboratorMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_collaborator_mails', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('sent_by');
            $table->string('send_to');
            $table->string('content');
            $table->tinyInteger('attachment');
            $table->unsignedBigInteger('work_order_id');
            $table->foreign('work_order_id')->references('id')->on('maintenance_work_orders')->onDelete('cascade');
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
        Schema::dropIfExists('work_order_collaborator_mails');
    }
}
