<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeptRelationInCollaborationTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collaboration_tasks', function (Blueprint $table) {
             $table->dropColumn('dept');
             $table->unsignedBigInteger('department_id')->nullable();
             $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collaboration_tasks', function (Blueprint $table) {
            $table->string('dept');
            $table->dropForeign(['department_id']);
        });
    }
}
