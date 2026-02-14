<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPolishTypeColumnInProductPolishTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_polish', function (Blueprint $table) {
            $table->string('polish_type')->after('polish_linear_cost_per_feet')->nullable();
            $table->string('polish_linear_cost_per_feet')->nullable()->change();
            $table->string('price')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_polish', function (Blueprint $table) {
            //
        });
    }
}
