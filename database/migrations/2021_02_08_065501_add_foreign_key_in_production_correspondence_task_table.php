<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyInProductionCorrespondenceTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('production_correspondence_tasks', function (Blueprint $table) {
            $table->unsignedInteger('production_correspondence_id')->after('production_correspondence_task_id')->nullable();
            $table->foreign('production_correspondence_id', 'production_correspondence_id_foreign')->references('production_correspondence_id')->on('production_correspondences')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('production_correspondence_tasks', function (Blueprint $table) {
            $table->dropForeign('production_correspondence_id_foreign');
        });
    }
}
