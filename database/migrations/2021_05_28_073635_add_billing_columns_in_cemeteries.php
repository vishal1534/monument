<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBillingColumnsInCemeteries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cemeteries', function (Blueprint $table) {
            $table->string('check_payable_to')->after('db_updated_date')->nullable();
            $table->boolean('w9_required')->after('check_payable_to')->nullable()->default(0);
            $table->string('mailing_address')->after('w9_required')->nullable();
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
            $table->dropColumn('check_payable_to');
            $table->dropColumn('w9_required');
            $table->dropColumn('mailing_address');

        });
    }
}
