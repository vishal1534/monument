<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInProductInstallationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_installation', function (Blueprint $table) {
            $table->float('installation_amount',8,2)->default(0)->nullable()->after('installation_price');
            $table->float('square_inch_installation',8,2)->default(0)->nullable()->after('installation_price');
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
            $table->dropColumn('installation_amount');
            $table->dropColumn('square_inch_installation');
        });
    }
}
