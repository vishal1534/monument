<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationInMemorialProductionProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('memorial_production_products', function (Blueprint $table) {
            $table->unsignedBigInteger('memorial_production_id')->nullable();
            $table->foreign('memorial_production_id')->references('id')->on('memorial_productions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('memorial_production_products', function (Blueprint $table) {
            $table->dropForeign(['memorial_production_id']);
            $table->dropColumn('memorial_production_id');
        });
    }
}
