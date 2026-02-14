<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnInImageAndFileTableOfMonument extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('monument_images', function(Blueprint $table){
           $table->string('name')->nullable();
       });
       Schema::table('monument_files', function (Blueprint $table){
           $table->string('name')->nullable();
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monument_images', function (Blueprint $table){
            $table->dropColumn('name');
        });
        Schema::table('monument_files', function (Blueprint $table){
            $table->string('name');
        });
    }
}
