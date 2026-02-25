<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrderCollaborationimagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_collaboration_images', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('path')->nullable();
            $table->string('size')->nullable();
            $table->string('uploaded_by')->nullable();
            $table->string('status')->nullable();
            $table->tinyInteger('sent_mail')->default(0);

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->text('notes')->nullable();
            $table->date('approved_at')->nullable();
            $table->string('moved_by')->nullable();
            $table->dateTime('last_sent_mail_date', $precision = 0)->nullable();

            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->foreign('rejected_by')->references('id')->on('users')->onDelete('set null');

            $table->boolean('is_approval_check')->nullable()->default(false);


            $table->bigInteger('work_order_id')->unsigned()->nullable();
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
        Schema::dropIfExists('work_order_collaborationimages');
    }
}
