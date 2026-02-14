<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDateTypeInCollaborationTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('production_collaboration_tasks', function (Blueprint $table) {
            $table->string('production_collaboration_task_date')->nullable()->change();
            $table->string('production_collaboration_closed_date')->nullable()->change();
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
            //
        });
    }
}
