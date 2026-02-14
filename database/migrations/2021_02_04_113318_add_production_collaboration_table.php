<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductionCollaborationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_collaborations', function (Blueprint $table) {
            $table->increments('production_collaboration_id');
            $table->string('production_collaboration_order_status')->nullable();
            $table->string('production_collaboration_paper_location')->nullable();
            $table->string('production_collaboration_order_on_hold')->nullable();
            $table->string('production_collaboration_order_on_hold_description')->nullable();
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
        Schema::dropIfExists('production_collaborations');
    }
}
