<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDateTypeInInstallation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('production_installations', function (Blueprint $table) {
            $table->string('production_installation_date_promised')->nullable()->change();
            $table->string('production_installation_install_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('production_installations', function (Blueprint $table) {
            //
        });
    }
}
