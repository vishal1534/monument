<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderInstallationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_installations', function (Blueprint $table) {
            $table->id();
            $table->string('foundation_person')->nullable();
            $table->tinyInteger('foundation_complete')->nullable()->default(0);
            $table->date('foundation_date')->nullable();
            $table->string('installer_name')->nullable();
            $table->tinyInteger('installation_complete')->nullable()->default(0);
            $table->date('installation_date')->nullable();
            $table->date('installation_complete_approved_date')->nullable();
            $table->tinyInteger('cemetery_called')->nullable()->default(0);
            $table->tinyInteger('grave_flagged')->nullable()->default(0);

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
        Schema::dropIfExists('order_installations');
    }
}
