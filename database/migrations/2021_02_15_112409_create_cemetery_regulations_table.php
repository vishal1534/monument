<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCemeteryRegulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cemetery_regulations', function (Blueprint $table) {
            $table->id();
            $table->boolean('auth_for_install')->nullable()->default(0);
            $table->boolean('auth_for_install_customer')->nullable()->default(0);
            $table->float('perpetual_care_fee')->nullable()->default(0);
            $table->string('cemeteries_style')->nullable();
            $table->float('flagging_fee')->nullable()->default(0);
            $table->string('apron_size')->nullable();
            $table->float('setting_fee')->nullable()->default(0);
            $table->string('mont_single_size')->nullable();
            $table->string('mont_double_size')->nullable();
            $table->float('mis_fee')->nullable()->default(0);
            $table->string('grave_size')->nullable();
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
        Schema::dropIfExists('cemetery_regulations');
    }
}
