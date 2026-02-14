<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMonumentIdColumnInProductInstallationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_installation', function (Blueprint $table) {
            $table->bigInteger('monument_id')->unsigned()->after('installation_price');
            $table->foreign('monument_id')->references('id')->on('monuments');
            $table->string('installation_price')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_installation', function (Blueprint $table) {
            $table->dropColumn('monument_id');
        });
    }
}
