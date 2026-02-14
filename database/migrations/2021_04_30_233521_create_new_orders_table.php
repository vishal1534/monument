<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('po')->nullable();
            $table->string('sales_person')->nullable();
            $table->string('order_type')->nullable();
            $table->float('sub_total')->nullable()->default(0);
            $table->float('tax_rate')->nullable()->default(0);
            $table->float('tax_amount')->nullable()->default(0);
            $table->float('invoice_total')->nullable()->default(0);
            $table->bigInteger('store_id')->unsigned()->nullable();
            $table->bigInteger('family_id')->unsigned()->nullable();
            $table->bigInteger('cemetery_id')->unsigned()->nullable();
            $table->bigInteger('invoice_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('store_id')->on('stores')->references('id');
            $table->foreign('family_id')->on('families')->references('id');
            $table->foreign('cemetery_id')->on('cemeteries')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
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
        Schema::dropIfExists('new_orders');
    }
}
