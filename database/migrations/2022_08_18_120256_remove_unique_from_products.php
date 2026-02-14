<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUniqueFromProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monuments', function (Blueprint $table) {
            $table->dropUnique(['product_number']);
        });

        Schema::table('services', function (Blueprint $table){
            $table->dropUnique(['product_number']);
        });

        Schema::table('simples', function(Blueprint $table){
            $table->dropUnique(['product_number']);
        });

        Schema::table('composites', function (Blueprint $table){
            $table->dropUnique(['product_number']);
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
            $table->unique('product_number');
        });

        Schema::table('services', function (Blueprint $table){
            $table->Unique('product_number');
        });

        Schema::table('simples', function(Blueprint $table){
            $table->Unique('product_number');
        });

        Schema::table('composites', function (Blueprint $table){
            $table->Unique('product_number');
        });
    }
}
