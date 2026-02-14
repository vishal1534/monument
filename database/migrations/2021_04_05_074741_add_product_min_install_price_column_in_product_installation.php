<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductMinInstallPriceColumnInProductInstallation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_installation', function (Blueprint $table) {
            $table->string('product_min_install_price')->after('id')->nullable();
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
            $table->dropColumn('product_min_install_price');

        });
    }
}
