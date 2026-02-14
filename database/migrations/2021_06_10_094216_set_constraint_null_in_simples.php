<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetConstraintNullInSimples extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('simples', function (Blueprint $table) {
            //$table->dropForeign(['category_id']);
            $table->foreign('category_id')
                ->references('id')
                ->on('simple_categories')
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
        Schema::table('simples', function (Blueprint $table) {
            //
        });
    }
}
