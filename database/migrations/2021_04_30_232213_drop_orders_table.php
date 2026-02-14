<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_stores', function (Blueprint $table) {
            $table->dropForeign('mps_order_stores_order_id_foreign');
        });
        Schema::table('order_family_informations', function (Blueprint $table) {
            $table->dropForeign('mps_order_family_informations_order_id_foreign');
        });
        Schema::table('order_payments', function (Blueprint $table) {
            $table->dropForeign('order_payments_order_id_foreign');
        });
        Schema::table('order_invoice_info', function (Blueprint $table) {
            $table->dropForeign('mps_order_invoice_info_order_id_foreign');
        });
        Schema::table('order_products', function (Blueprint $table) {
//            $table->dropForeign('order_products_order_id_foreign');
        });

        Schema::dropIfExists('order_stores');
        Schema::dropIfExists('order_family_informations');
        Schema::dropIfExists('order_payments');
        Schema::dropIfExists('orders');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
