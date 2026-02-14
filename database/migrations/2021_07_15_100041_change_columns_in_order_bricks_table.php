<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsInOrderBricksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_bricks', function (Blueprint $table) {
            $table->string('first_name')->nullable()->change();
            $table->string('first_address')->nullable()->change();
            $table->string('first_phone')->nullable()->change();
            $table->string('second_name')->nullable()->change();
            $table->string('second_address')->nullable()->change();
            $table->string('second_phone')->nullable()->change();
            $table->string('approved_by')->nullable()->change();
            $table->date('date')->nullable()->change();
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
            //
        });
    }
}
