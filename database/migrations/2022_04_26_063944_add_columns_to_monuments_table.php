<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToMonumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monuments', function (Blueprint $table) {
            $table->integer('quantity_backordered')->nullable()->after('quantity_stocked');
            $table->integer('total_weight')->nullable()->after('total_added');
            $table->string('tax_info')->nullable()->after('total_added');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monuments', function (Blueprint $table) {
            $table->dropColumn(['quantity_backordered', 'total_weight', 'tax_info']);
        });
    }
}
