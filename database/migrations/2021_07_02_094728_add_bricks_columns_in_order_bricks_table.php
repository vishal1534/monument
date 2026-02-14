<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBricksColumnsInOrderBricksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_bricks', function (Blueprint $table) {
            $table->string('brick_1')->nullable()->after('first_phone');
            $table->string('brick_2')->nullable()->after('second_phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_bricks', function (Blueprint $table) {
            $table->dropColumn('brick_1');
            $table->dropColumn('brick_2');
        });
    }
}
