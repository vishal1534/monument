<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('account_number')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('date')->nullable();
            $table->string('sales_person')->nullable();
            $table->string('last_name_on_stone')->nullable();
            $table->float('tax_rate')->nullable()->default(0);
            $table->string('callback_date')->nullable();
            $table->tinyInteger('installation')->nullable();
            $table->string('referred_by')->nullable();
            $table->tinyInteger('call_customer')->nullable();
            $table->text('comments')->nullable();
            $table->text('who_follow_up')->nullable();
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
        Schema::dropIfExists('quotes');
    }
}
