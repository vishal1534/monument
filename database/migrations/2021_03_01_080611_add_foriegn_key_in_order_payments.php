<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForiegnKeyInOrderPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_payments', function (Blueprint $table) {
            //
            $table->unsignedInteger('order_id')->after('order_payment_amount')->nullable();
            $table->foreign('order_id','order_payments_order_id_foreign')->references('order_id')->on('orders')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_payments', function (Blueprint $table) {
            //
            $table->dropForeign([
                'order_payments_order_id_foreign'
            ]);
        });
    }
}
