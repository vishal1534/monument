<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropProductionRelatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productions', function (Blueprint $table){
            $table->dropForeign('mps_productions_production_collaboration_id_foreign');
            $table->dropForeign('mps_productions_production_correspondence_id_foreign');
            $table->dropForeign('mps_productions_production_installation_id_foreign');
            $table->dropForeign('mps_productions_production_order_id_foreign');
        });

        Schema::dropIfExists('production_collaboration_tasks');
        Schema::dropIfExists('production_collaborations');
        Schema::dropIfExists('production_correspondence_tasks');
        Schema::dropIfExists('production_correspondences');
        Schema::dropIfExists('production_installations');
        Schema::dropIfExists('production_orders');
        Schema::dropIfExists('productions');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
