<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSpecialNotesColumnTypeInInstallationPlacementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('installation_placements', function (Blueprint $table) {
            $table->text('special_notes')->change();
            $table->text('burial_details')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('installation_placements', function (Blueprint $table) {
            $table->string('special_notes')->change();
            $table->string('burial_details')->change();
        });
    }
}
