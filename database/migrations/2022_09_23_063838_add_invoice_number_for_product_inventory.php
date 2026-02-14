<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceNumberForProductInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monument_inventories', function(Blueprint $table){
           $table->unsignedBigInteger('invoice_number')->nullable()->after('by_whom');
           $table->foreign('invoice_number')->references('invoice_number')->on('invoices')->onDelete('cascade');
        });

        Schema::table('service_inventories', function(Blueprint $table){
            $table->unsignedBigInteger('invoice_number')->nullable()->after('by_whom');
            $table->foreign('invoice_number')->references('invoice_number')->on('invoices')->onDelete('cascade');
        });

        Schema::table('simple_inventories', function(Blueprint $table){
            $table->unsignedBigInteger('invoice_number')->nullable()->after('by_whom');
            $table->foreign('invoice_number')->references('invoice_number')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monument_inventories', function(Blueprint $table){
            $table->dropForeign(['invoice_number']);
            $table->dropColumn(['invoice_number']);
        });

        Schema::table('service_inventories', function(Blueprint $table){
            $table->dropForeign(['invoice_number']);
            $table->dropColumn(['invoice_number']);
        });

        Schema::table('simple_inventories', function(Blueprint $table){
            $table->dropForeign(['invoice_number']);
            $table->dropColumn(['invoice_number']);
        });

    }
}
