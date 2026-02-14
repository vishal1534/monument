<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonumentAgreementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monument_agreement', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('option_1')->nullable()->comment('1/2 of the monument must be paid for when the order is placed.');
            $table->tinyInteger('option_2')->nullable()->comment('If monument is not paid for in full within 45 days of completion');
            $table->tinyInteger('option_3')->nullable()->comment('Your monument must be paid in full before it will be installed at the cemetery');
            $table->tinyInteger('option_4')->nullable()->comment('You are responsible for any additional fees or price');
            $table->tinyInteger('option_5')->nullable()->comment(' Once you have signed the final rough draft of what your monument will look like');
            $table->string('initials')->nullable();
            $table->tinyInteger('option_6')->nullable()->comment('Once the order is written if you wish to have anything changed with your order the price may increase or decrease.');
            $table->tinyInteger('option_7')->nullable()->comment('If you decide to cancel your order it must be within 25 days of placing the order.');
            $table->tinyInteger('option_8')->nullable()->comment(' Frisbie Monuments guarantees the monument to be free of defects that naturally occur.');
            $table->tinyInteger('option_9')->nullable()->comment(' Frisbie Monuments guarantees the foundation work to be free of defects.');
            $table->tinyInteger('option_10')->nullable()->comment('Our guarantee is that if you are not 100% satisfied with the outcome of your order');
            $table->tinyInteger('option_11')->nullable()->comment('Date Promised');
            $table->tinyInteger('date_promised')->nullable()->comment('');
            $table->string('approval')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_signature')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('name_on_stone')->nullable();
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
        Schema::dropIfExists('monument_agreement');
    }


}
