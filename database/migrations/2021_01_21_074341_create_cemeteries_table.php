<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCemeteriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cemeteries', function (Blueprint $table) {
            $table->id();
			$table->string('company')->nullable();
			$table->string('company_first_name')->nullable();
			$table->string('company_last_name')->nullable();
			$table->string('job_title')->nullable();
			$table->string('additional_contact')->nullable();
			$table->string('email')->nullable();
			$table->string('web_page')->nullable();
			$table->string('gps')->nullable();
			$table->string('cemetery_file')->nullable();
			$table->string('business_phone')->nullable();
			$table->string('home_phone')->nullable();
			$table->string('fax_number')->nullable();
			$table->string('mobile_phone')->nullable();
			$table->string('street')->nullable();
			$table->string('zip_code')->nullable();
			$table->text('notes')->nullable();
			$table->integer('cemetery_categories_id')->nullable();
			$table->integer('state_id')->nullable();
			$table->integer('county_id')->nullable();
			$table->integer('city_id')->nullable();
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
        Schema::dropIfExists('cemeteries');
    }
}
