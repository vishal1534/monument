<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCloseColumnInProductionCollaborationTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('production_collaboration_tasks', function (Blueprint $table) {
            $table->string('production_collaboration_task_close')->after('production_collaboration_task_type')->nullable();

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
            $table->dropColumn('production_collaboration_task_close');
        });
    }
}
