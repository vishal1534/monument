<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMonumentSimpleServiceColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monuments', function(Blueprint $table){
            $table->string('supplier')->nullable()->after('stock_info');
        });

        Schema::table('simples', function(Blueprint $table){
            $table->string('supplier')->nullable()->after('stock_info');
        });

        Schema::table('services', function (Blueprint $table){
            $table->string('supplier')->nullable()->after('stock_info');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monuments', function(Blueprint $table){
            $table->dropColumn('supplier');
        });

        Schema::table('simples', function(Blueprint $table){
            $table->dropColumn('supplier');
        });

        Schema::table('services', function(Blueprint $table){
            $table->dropColumn('supplier');
        });
    }
}
