<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnNameLocationTitleInPaperLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paper_location', function (Blueprint $table) {
            $table->renameColumn('title', 'location_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paper_location', function (Blueprint $table) {
            $table->renameColumn('location_title', 'title');
        });
    }
}
