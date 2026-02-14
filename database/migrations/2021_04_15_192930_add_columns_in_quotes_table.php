<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->renameColumn('last_name_on_stone', 'name_on_stone');
            $table->float('sub_total')->nullable()->default(0)->after('tax_rate');
            $table->float('tax_amount')->nullable()->default(0)->after('sub_total');
            $table->float('total_selling_price')->nullable()->default(0)->after('tax_amount');
            $table->bigInteger('family_id')->unsigned()->nullable()->after('store_id');
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
            $table->renameColumn('name_on_stone', 'last_name_on_stone');
            $table->dropColumn('sub_total');
            $table->dropColumn('tax_amount');
            $table->dropColumn('total_selling_price');
            $table->dropColumn('family_id');
        });
    }
}
