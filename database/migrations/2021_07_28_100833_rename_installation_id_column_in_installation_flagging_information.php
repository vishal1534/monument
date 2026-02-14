<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameInstallationIdColumnInInstallationFlaggingInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('installation_flagging_information', function (Blueprint $table) {
            $table->renameColumn('installation_id', 'order_installation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('installation_flagging_information', function (Blueprint $table) {
            $table->renameColumn('order_installation_id', 'installation_id');
        });
    }
}
