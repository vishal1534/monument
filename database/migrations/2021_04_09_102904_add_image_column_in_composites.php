<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageColumnInComposites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('composites', function (Blueprint $table) {
            $table->string('composite_number')->after('id')->nullable();
            $table->integer('composite_added')->after('composite_on_hand')->nullable();
            $table->string('composite_image')->after('composite_added')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('composites', function (Blueprint $table) {
            $table->dropColumn('composite_number');
            $table->dropColumn('composite_added');
            $table->dropColumn('composite_image');
        });
    }
}
