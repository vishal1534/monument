<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetCascadeDeleteInstallerInInstallationDailyLoadCheckLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('installation_daily_load_check_lists', function (Blueprint $table) {
            $table->dropForeign(['installer_id']);
            $table->foreign('installer_id')->references('id')->on('installers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('installation_daily_load_check_lists', function (Blueprint $table) {
            //
        });
    }
}
