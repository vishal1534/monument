<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyInSimples extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('simples', function (Blueprint $table) {
            $table->unsignedBigInteger('simple_category_id')->after('simple_description')->nullable();
            //$table->foreign('simple_category_id','simple_category_id_foreign')->references('id')->on('simples')->onDelete('cascade');
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
            //$table->dropForeign('simple_category_id_foreign');
        });
    }
}
