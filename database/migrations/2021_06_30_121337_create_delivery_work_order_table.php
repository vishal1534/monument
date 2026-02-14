<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryWorkOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_work_order', function (Blueprint $table) {
            $table->id();
            $table->string('other_location')->nullable();
            $table->string('company')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('contact')->nullable();
            $table->string('phone')->nullable();
            $table->text('work_to_be_done')->nullable();
            $table->text('stone_details')->nullable();
            $table->text('supplies_needed')->nullable();
            $table->text('work_order_notes')->nullable();
            $table->string('completed_by')->nullable();
            $table->dateTime('date')->nullable();
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
        Schema::dropIfExists('delivery_work_order');
    }
}
