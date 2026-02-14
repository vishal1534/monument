<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTitleColumnInProductSides extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_sides', function (Blueprint $table) {
            $table->renameColumn('product_side_title','title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_sides', function (Blueprint $table) {
            $table->renameColumn('title','product_side_title');
        });
    }
}
