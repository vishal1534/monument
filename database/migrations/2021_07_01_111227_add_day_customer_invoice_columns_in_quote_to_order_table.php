<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDayCustomerInvoiceColumnsInQuoteToOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quote_to_order', function (Blueprint $table) {
            $table->string('day')->nullable()->after('date');
            $table->string('customer_name')->nullable()->after('day');
            $table->string('invoice_no')->nullable()->after('customer_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quote_to_order', function (Blueprint $table) {
            $table->dropColumn('day');
            $table->dropColumn('customer_name');
            $table->dropColumn('invoice_no');
        });
    }
}
