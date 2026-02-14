<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bill_address')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('salutation')->nullable();
            $table->string('ship_address')->nullable();
            $table->string('other_contact')->nullable();
            $table->string('ship_city')->nullable();
            $table->string('ship_state')->nullable();
            $table->string('ship_zip')->nullable();
            $table->string('attention')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
