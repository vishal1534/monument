<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderStatusColumnInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->nullable()->after('tax_amount');
            $table->string('paper_location')->nullable()->after('status');
            $table->string('on_hold')->nullable()->after('paper_location');
            $table->string('on_hold_description')->nullable()->after('on_hold');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('paper_location');
            $table->dropColumn('on_hold');
            $table->dropColumn('on_hold_description');
        });
    }
}
