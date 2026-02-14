<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInEngravingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_engraves', function (Blueprint $table) {
            $table->string('engrave_type')->nullable()->after('id');
            $table->float('engrave_square_inches',8,2)->nullable()->after('engrave_type');
            $table->float('engrave_front_total_price',8,2)->nullable()->after('engrave_front_square');
            $table->float('engrave_back_total_price',8,2)->nullable()->after('engrave_back_square');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('engravings', function (Blueprint $table) {
            $table->dropColumn('engrave_type');
            $table->dropColumn('engrave_square_inches');
            $table->dropColumn('engrave_front_total_price');
            $table->dropColumn('engrave_back_total_price');
        });
    }
}
