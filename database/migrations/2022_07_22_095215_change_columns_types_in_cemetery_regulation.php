<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsTypesInCemeteryRegulation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cemetery_regulations', function (Blueprint $table) {
            $table->string('perpetual_care_fee')->nullable()->change();
            $table->string('flagging_fee')->nullable()->change();
            $table->string('setting_fee')->nullable()->change();
            $table->string('mis_fee')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cemetery_regulations', function (Blueprint $table) {
            $table->float('perpetual_care_fee')->nullable()->default(0)->change();
            $table->float('flagging_fee')->nullable()->default(0)->change();
            $table->float('setting_fee')->nullable()->default(0)->change();
            $table->float('mis_fee')->nullable()->default(0)->change();
        });
    }
}
