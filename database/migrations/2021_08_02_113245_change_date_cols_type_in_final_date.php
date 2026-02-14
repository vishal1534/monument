<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDateColsTypeInFinalDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('final_date', function (Blueprint $table) {
            $table->date('birth_date')->change();
            $table->date('final_date')->change();
            $table->date('rubbing_date')->change();
            $table->date('date')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('final_date', function (Blueprint $table) {
            $table->dateTime('birth_date')->change();
            $table->dateTime('final_date')->change();
            $table->dateTime('rubbing_date')->change();
            $table->dateTime('date')->change();
        });
    }
}
