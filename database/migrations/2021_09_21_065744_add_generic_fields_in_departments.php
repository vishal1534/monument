<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGenericFieldsInDepartments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->renameColumn('department_title','title');
            $table->renameColumn('department_email','email_message');
            $table->string('text_message')->nullable();
            $table->tinyInteger('generic')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->renameColumn('title','department_title');
            $table->renameColumn('email_message','department_email');
            $table->dropColumn('text_message');
            $table->dropColumn('generic');
        });
    }
}
