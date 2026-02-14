<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTruckInfoColumnInLoaders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loaders', function (Blueprint $table) {
            $table->string('truck_name_info')->nullable();
            $table->string('sign_of_checker')->nullable();
            $table->string('sign_of_installer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loaders', function (Blueprint $table) {
            $table->dropColumn('truck_name_info');
            $table->dropColumn('sign_of_checker');
            $table->dropColumn('sign_of_installer');
        });
    }
}
