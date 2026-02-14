<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyFoundationDepthAndVaseDirectionInInstallations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('installations', function (Blueprint $table) {
            $table->unsignedBigInteger('vase_direction_id')->nullable()->after('order_id');
            $table->foreign('vase_direction_id')->references('id')->on('vase_directions')->onDelete('set null');
            $table->unsignedBigInteger('foundation_depth_id')->nullable()->after('order_id');
            $table->foreign('foundation_depth_id')->references('id')->on('foundation_depths')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('installations', function (Blueprint $table) {
            $table->dropForeign(['vase_direction_id']);
            $table->dropColumn(['vase_direction_id']);
            $table->dropForeign(['foundation_depth_id']);
            $table->dropColumn(['foundation_depth_id']);
        });
    }
}
