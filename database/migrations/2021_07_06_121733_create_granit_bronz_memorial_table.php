<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGranitBronzMemorialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('granit_bronz_memorial', function (Blueprint $table) {
            $table->id();
            $table->string('customer_account_no')->nullable();
            $table->string('order_types')->nullable();
            $table->string('preneed_contract_no')->nullable();
            $table->date('initial_payment_date')->nullable();
            $table->integer('length_of_contract')->nullable();
            $table->string('bronze_design')->nullable();
            $table->string('bronze_size')->nullable();
            $table->string('granite_color')->nullable();
            $table->string('granite_size')->nullable();
            $table->string('granite_finish')->nullable();
            $table->string('vases')->nullable();
            $table->string('oxidation_colors')->nullable();
            $table->string('letter_styles')->nullable();
            $table->string('scroll_types')->nullable();
            $table->string('scroll_no')->nullable();
            $table->string('original_order_no')->nullable();
            $table->string('custom_colors')->nullable();
            $table->string('custom_color_brand')->nullable();
            $table->string('custom_color_color')->nullable();
            $table->string('custom_color_color_no')->nullable();
            $table->string('layouts')->nullable();
            $table->string('inscription')->nullable();
            $table->string('emblem_one')->nullable();
            $table->string('emblem_two')->nullable();
            $table->string('emblem_three')->nullable();
            $table->string('emblem_four')->nullable();
            $table->string('emblem_five')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('granit_bronze_account_no')->nullable();
            $table->string('invoicing_address')->nullable();
            $table->string('granit_bronz_section')->nullable();
            $table->string('granit_bronz_section_one')->nullable();
            $table->string('granit_bronz_section_two')->nullable();
            $table->string('granit_bronz_section_three')->nullable();
            $table->string('price')->nullable();
            $table->string('scrolls')->nullable();
            $table->string('extra_lettering')->nullable();
            $table->string('graphic_color')->nullable();
            $table->string('miscellaneous')->nullable();
            $table->string('tax')->nullable();
            $table->string('total')->nullable();
            $table->string('paid_with_order')->nullable();
            $table->string('balance_due')->nullable();
            $table->string('ordered_by')->nullable();

            $table->bigInteger('order_id')->unsigned();
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
        Schema::dropIfExists('granit_bronz_memorial');
    }
}
