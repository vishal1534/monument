<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSpecialInstructionsColumnInGranitBronzPrecious extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('granit_bronz_precious', function (Blueprint $table) {
            $table->text('special_instructions')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('granit_bronz_precious', function (Blueprint $table) {
            $table->string('special_instructions')->change();
        });
    }
}
