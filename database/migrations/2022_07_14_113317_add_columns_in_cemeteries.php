<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInCemeteries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cemeteries', function (Blueprint $table) {
            $table->string('city_name')->nullable()->after('mailing_address');
            $table->string('state_name')->nullable()->after('mailing_address');
            $table->string('zip')->nullable()->after('mailing_address');
            $table->string('flagging_info')->nullable()->after('zip_code');
            $table->string('installation_zone')->nullable()->after('zip_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cemeteries', function (Blueprint $table) {
            $table->dropColumn(['city_name', 'state_name', 'zip', 'flagging_info', 'installation_zone']);
        });
    }
}
