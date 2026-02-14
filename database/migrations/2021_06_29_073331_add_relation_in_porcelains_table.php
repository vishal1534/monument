<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationInPorcelainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('porcelains', function (Blueprint $table) {
            $table->unsignedBigInteger('format_id')->nullable();
            $table->foreign('format_id')->references('id')->on('porcelain_formats')->onDelete('set null');
            $table->unsignedBigInteger('shape_id')->nullable();
            $table->foreign('shape_id')->references('id')->on('porcelain_shapes')->onDelete('set null');
            $table->unsignedBigInteger('size_id')->nullable();
            $table->foreign('size_id')->references('id')->on('porcelain_size')->onDelete('set null');
            $table->unsignedBigInteger('part_id')->nullable();
            $table->foreign('part_id')->references('id')->on('porcelain_parts')->onDelete('set null');
            $table->unsignedBigInteger('orientation_id')->nullable();
            $table->foreign('orientation_id')->references('id')->on('porcelain_orientations')->onDelete('set null');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('porcelains', function (Blueprint $table) {
            $table->dropForeign(['format_id']);
            $table->dropColumn('format_id');
            $table->dropForeign(['shape_id']);
            $table->dropColumn('shape_id');
            $table->dropForeign(['size_id']);
            $table->dropColumn('size_id');
            $table->dropForeign(['part_id']);
            $table->dropColumn('part_id');
            $table->dropForeign(['orientation_id']);
            $table->dropColumn('orientation_id');
            $table->dropForeign(['order_id']);
            $table->dropColumn('order_id');
        });
    }
}
