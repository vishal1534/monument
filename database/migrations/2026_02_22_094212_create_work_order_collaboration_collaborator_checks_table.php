<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrderCollaborationCollaboratorChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_collaboration_collaborator_checks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('work_order_id');
            $table->unsignedBigInteger('collaborator_id');

            $table->boolean('is_check');

            $table->timestamps();
            
            $table->foreign('work_order_id', 'wo_collab_chk_wo_fk')
                ->references('id')
                ->on('maintenance_work_orders')
                ->onDelete('cascade');

            $table->foreign('collaborator_id', 'wo_collab_chk_collab_fk')
                ->references('id')
                ->on('work_order_collaborators')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_order_collaboration_collaborator_checks');
    }
}
