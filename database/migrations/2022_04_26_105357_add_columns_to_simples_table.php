<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSimplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('simples', function (Blueprint $table) {
            $table->string('type')->nullable()->after('product_cost');
            $table->string('color')->nullable()->after('product_cost');
            $table->string('shape')->nullable()->after('product_cost');
            $table->integer('weight')->nullable()->after('product_cost');
            $table->string('tax_info')->nullable()->after('product_cost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('simples', function (Blueprint $table) {
            $table->dropColumn(['type', 'color', 'shape', 'weight', 'tax_info']);
        });
    }
}
