<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersInvoiceInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_invoice_info', function (Blueprint $table) {
            $table->increments('order_invoice_info_id');
            $table->unsignedInteger('order_id')->nullable();
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->string('order_invoice_info_type_of_order')->nullable();
            $table->date('order_invoice_info_invoice_closed_date')->nullable();
            $table->string('order_invoice_info_original_invoice_number')->nullable();
            $table->string('order_invoice_info_ship_invoice_date')->nullable();
            $table->string('order_invoice_info_sales_person')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_invoice_info');
    }
}
