<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeProductNumberServiceSimpleCompositeMonumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monuments', function(Blueprint $table){
            $table->string('product_number')->change();
        });

        Schema::table('services', function(Blueprint $table){
            $table->string('product_number')->change();
        });

        Schema::table('simples', function(Blueprint $table){
            $table->string('product_number')->change();
        });

        Schema::table('composites', function(Blueprint $table){
            $table->string('product_number')->change();
        });
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
