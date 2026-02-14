<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameComapnyNameInCemeteries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cemeteries', function (Blueprint $table) {
            $table->renameColumn('company_first_name','contact_first_name');
            $table->renameColumn('company_last_name','contact_last_name');
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
            $table->renameColumn('contact_first_name','company_first_name');
            $table->renameColumn('contact_last_name','company_last_name');
        });
    }
}
