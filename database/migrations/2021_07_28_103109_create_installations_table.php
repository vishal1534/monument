<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installations', function (Blueprint $table) {
            $table->id();
            $table->string('install_who')->nullable();
            $table->string('install_where')->nullable();
            $table->string('cemetery_amount')->nullable();
            $table->string('cemetery_paid')->nullable();
            $table->string('cemetery_called_to_flag')->nullable();
            $table->string('grave_flagged')->nullable();
            $table->string('cemetery_take_mail_check')->nullable();
            $table->string('installation_zone')->nullable();
            $table->date('date_promised')->nullable();
            $table->string('foundation_done')->nullable();
            $table->string('set_stone')->nullable();
            $table->date('install_date')->nullable();
            $table->string('customer_called_after_installation')->nullable();
            $table->text('install_memo')->nullable();

            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
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
        Schema::dropIfExists('installations');
    }
}
