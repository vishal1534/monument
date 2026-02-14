<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeColumnInProductionCollaborationTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('production_collaboration_tasks', function (Blueprint $table) {
            $table->string('production_collaboration_task_type')->after('production_collaboration_created_by')->nullable();
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
            $table->dropColumn('production_collaboration_task_type');
        });
    }
}
