<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsInGranitBronzMemorialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('granit_bronz_memorial', function (Blueprint $table) {
            $table->string('granit_bronz_section', 500)->change();
            $table->string('shipping_address',500)->change();
            $table->string('invoicing_address',500)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('granit_bronz_memorial', function (Blueprint $table) {
            //
        });
    }
}
