<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCemeteryBillingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cemetery_billing', function (Blueprint $table) {
            $table->id();
            $table->string('check_payable_to')->nullable();
			$table->boolean('w9_required')->nullable()->default(0);
			$table->string('mailing_address')->nullable();
			//$table->integer('cemetery_id')->nullable();
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
        Schema::dropIfExists('cemetery_billing');
    }
}
