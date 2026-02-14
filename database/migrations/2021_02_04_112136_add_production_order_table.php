<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductionOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_orders', function (Blueprint $table) {
            $table->increments('production_order_id');
            $table->string('production_order_email')->nullable();
            $table->string('production_order_company')->nullable();
            $table->string('production_order_name')->nullable();
            $table->string('production_order_contact_number')->nullable();
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
        Schema::dropIfExists('production_orders');
    }
}
