<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMonumentIdColumnInProductEngravesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_engraves', function (Blueprint $table) {
            $table->bigInteger('monument_id')->unsigned()->after('engrave_premium_cost');
            $table->foreign('monument_id')->references('id')->on('monuments');
            $table->string('engrave_front_square')->nullable()->change();
            $table->string('engrave_back_square')->nullable()->change();
            $table->string('engrave_premium_cost')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_engraves', function (Blueprint $table) {
            $table->dropColumn('monument_id');
        });
    }
}
