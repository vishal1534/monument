<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallationPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installation_payments', function (Blueprint $table) {
            $table->id();
            $table->string('make_check_payable_to')->nullable();
            $table->string('mailing_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('cemetery_fees')->nullable();
            $table->string('check_wrote_on')->nullable();
            $table->tinyInteger('check_delivered')->nullable()->default(0)->comment('options: 0. Mailed, 1.Take to Jobsite');

            $table->bigInteger('installation_id')->unsigned()->nullable();
            $table->foreign('installation_id')->references('id')->on('order_installations')->onDelete('cascade');

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
        Schema::dropIfExists('installation_payments');
    }
}
