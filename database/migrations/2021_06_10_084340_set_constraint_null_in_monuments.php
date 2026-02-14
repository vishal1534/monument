<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetConstraintNullInMonuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monuments', function (Blueprint $table) {
            $table->dropForeign(['color_id']);
            $table->foreign('color_id')
                ->references('id')
                ->on('product_colors')
              ->onDelete('set null');
            $table->dropForeign(['side_id']);
            $table->foreign('side_id')
                ->references('id')
                ->on('product_sides')
                ->onDelete('set null');
            $table->dropForeign(['shape_id']);
            $table->foreign('shape_id')
                ->references('id')
                ->on('product_shapes')
                ->onDelete('set null');
            $table->dropForeign(['type_id']);
            $table->foreign('type_id')
                ->references('id')
                ->on('product_types')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monuments', function (Blueprint $table) {
            //
        });
    }
}
