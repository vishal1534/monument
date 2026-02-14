<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollaborationCollaboratorCheckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collaboration_collaborator_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collaboration_id')->constrained('collaborations')->onDelete('cascade');
            $table->foreignId('collaborator_id')->constrained('collaborators')->onDelete('cascade');
            $table->boolean('is_check');
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
        Schema::dropIfExists('collaboration_collaborator_checks');
    }
}
