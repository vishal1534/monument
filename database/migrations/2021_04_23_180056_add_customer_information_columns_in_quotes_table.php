<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerInformationColumnsInQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->string('customer_name')->nullable()->after('name_on_stone');
            $table->string('customer_email')->nullable()->after('customer_name');
            $table->string('family_address')->nullable()->after('customer_email');
            $table->string('family_city')->nullable()->after('family_address');
            $table->string('family_state')->nullable()->after('family_city');
            $table->integer('family_zip')->nullable()->after('family_state');
            $table->integer('family_phone')->nullable()->after('family_zip');
            $table->bigInteger('user_id')->unsigned()->nullable()->after('family_phone');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn('customer_name');
            $table->dropColumn('customer_email');
            $table->dropColumn('family_address');
            $table->dropColumn('family_city');
            $table->dropColumn('family_state');
            $table->dropColumn('family_zip');
            $table->dropColumn('family_phone');
            $table->dropColumn('user_id');
        });
    }
}
