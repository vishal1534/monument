<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCemeteryFileInCemeteries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cemeteries', function (Blueprint $table) {
            $table->renameColumn('cemetery_file','image');
            $table->renameColumn('cemetery_category_id','category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cemeteries', function (Blueprint $table) {
            $table->renameColumn('image','cemetery_file');
            $table->renameColumn('category_id','cemetery_category_id');
        });
    }
}
