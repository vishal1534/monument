<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyInProductionCollaborationTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('production_collaboration_tasks', function (Blueprint $table) {
            $table->unsignedInteger('production_collaboration_id')->after('production_collaboration_task_id')->nullable();
            $table->foreign('production_collaboration_id', 'production_collaboration_id_foreign')->references('production_collaboration_id')->on('production_collaborations')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('production_collaboration_tasks', function (Blueprint $table) {
            $table->dropForeign('production_collaboration_id_foreign');
        });
    }
}
