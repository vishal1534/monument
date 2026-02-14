<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFamilyColumnsInCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->renameColumn('company_name','name');
            $table->renameColumn('bill_address','address');
            $table->renameColumn('contact_name','contact');
            $table->renameColumn('other_contact','contact_2');
            $table->renameColumn('salutation','type');
            $table->renameColumn('fax','phone_2');
            $table->renameColumn('notes','acct_payable');
            $table->renameColumn('ship_city','email');
            $table->renameColumn('ship_state','email_2');
            $table->dropColumn('ship_address');
            $table->dropColumn('attention');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->renameColumn('name','company_name');
            $table->renameColumn('address','bill_address');
            $table->renameColumn('contact', 'contact_name');
            $table->renameColumn('contact_2', 'other_contact');
            $table->renameColumn('type', 'salutation');
            $table->renameColumn('phone_2', 'fax');
            $table->renameColumn('acct_payable','notes');
            $table->renameColumn('email', 'ship_city');
            $table->renameColumn('email_2', 'ship_state');
            $table->string('ship_address')->nullable();
            $table->string('attention')->nullable();
        });
    }
}
