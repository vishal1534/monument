<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsFromProductionSandblastingListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('production_sandblasting_list', function (Blueprint $table) {
            $table->dropColumn('invoice_no');
            $table->dropColumn('last_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('production_sandblasting_list', function (Blueprint $table) {
            $table->string('invoice_no')->nullable();
            $table->string('last_name')->nullable();
        });
    }
}
