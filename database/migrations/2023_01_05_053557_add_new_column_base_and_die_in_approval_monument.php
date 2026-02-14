<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnBaseAndDieInApprovalMonument extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('approval_monument', function (Blueprint $table) {
            $table->after('date', function($table){
                $table->string('base')->nullable();
                $table->string('die')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('approval_monument', function (Blueprint $table) {
            $table->dropColumn('base', 'die');
        });
    }
}
