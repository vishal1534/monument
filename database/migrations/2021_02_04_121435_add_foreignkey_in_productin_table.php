<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignkeyInProductinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->unsignedInteger('production_collaboration_id')->after('production_install_from_cemetery')->nullable();
            $table->foreign('production_collaboration_id')->references('production_collaboration_id')->on('production_collaborations')->onDelete('cascade');

            $table->unsignedInteger('production_correspondence_id')->after('production_collaboration_id')->nullable();
            $table->foreign('production_correspondence_id')->references('production_correspondence_id')->on('production_correspondences')->onDelete('cascade');

            $table->unsignedInteger('production_installation_id')->after('production_special_install_instructions')->nullable();
            $table->foreign('production_installation_id')->references('production_installation_id')->on('production_installations')->onDelete('cascade');

            $table->unsignedInteger('production_order_id')->after('production_installation_id')->nullable();
            $table->foreign('production_order_id')->references('production_order_id')->on('production_orders')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->dropForeign([
                'production_production_collaboration_id_foreign',
                'production_correspondence_id_foreign',
                'production_installation_id_foreign',
                'production_order_id_foreign'
                ]);
        });
    }
}
