<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignatureColumnInInstallationPlacements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('installation_placements', function (Blueprint $table) {
            $table->string('signature')->nullable()->after('placement_date');
            $table->string('face_dimension')->nullable()->after('name_should_face');

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
            $table->dropColumn('signature');
            $table->dropColumn('face_dimension');
        });
    }
}
