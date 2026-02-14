<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyInOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('store_id')->nullable();
            $table->foreign('store_id','order_store_id_foreign')->references('id')->on('stores')->onDelete('cascade');
            $table->unsignedBigInteger('family_id')->nullable();
            $table->foreign('family_id','order_family_id_foreign')->references('id')->on('families')->onDelete('cascade');
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
            $table->dropForeign('order_store_id_foreign');
            $table->dropForeign('order_family_id_foreign');
        });
    }
}
