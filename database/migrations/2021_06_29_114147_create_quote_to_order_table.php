<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuoteToOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_to_order', function (Blueprint $table) {
            $table->id();
            $table->string('appt_location')->nullable();
            $table->string('store_credit')->nullable();
            $table->date('date')->nullable();
            $table->string('part_no')->nullable();
            $table->string('color')->nullable();
            $table->string('type')->nullable();
            $table->string('shape')->nullable();
            $table->string('size')->nullable();
            $table->string('top_finish')->nullable();
            $table->string('base')->nullable();
            $table->string('base_finish')->nullable();
            $table->string('picture')->nullable();
            $table->string('last_name_on_monument')->nullable();
            $table->string('purchaser')->nullable();
            $table->string('city_state_zip')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('alt_phone')->nullable();
            $table->string('email')->nullable();
            $table->string('first_name')->nullable();
            $table->date('first_birth_date')->nullable();
            $table->date('first_death_date')->nullable();
            $table->string('second_name')->nullable();
            $table->date('second_birth_date')->nullable();
            $table->date('second_death_date')->nullable();
            $table->date('marriage_date')->nullable();
            $table->string('cemetery')->nullable();
            $table->string('cemetery_city_state_zip')->nullable();
            $table->string('price')->nullable();
            $table->string('engraving')->nullable();
            $table->string('back')->nullable();
            $table->string('adt_lattering')->nullable();
            $table->string('laser_etching')->nullable();
            $table->string('apron')->nullable();
            $table->string('other')->nullable();
            $table->string('vases')->nullable();
            $table->string('setting')->nullable();
            $table->string('freight')->nullable();
            $table->string('total')->nullable();
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
        Schema::dropIfExists('quote_to_order');
    }
}
