<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonumentWorkOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monument_work_order', function (Blueprint $table) {
            $table->id();
            $table->text('monument_location')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('work_to_be_done')->nullable();
            $table->string('stone_details')->nullable();
            $table->string('completed_by')->nullable();
            $table->text('supplies_needed')->nullable();
            $table->text('work_order_notes')->nullable();
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
        Schema::dropIfExists('monument_work_order');
    }
}
