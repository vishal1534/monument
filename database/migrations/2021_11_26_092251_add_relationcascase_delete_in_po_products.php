<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationcascaseDeleteInPoProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('po_products', function (Blueprint $table) {
            $table->dropForeign(['po_order_id']);
            $table->foreign('po_order_id')->references('id')->on('po_orders')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('po_products', function (Blueprint $table) {
        });
    }
}
