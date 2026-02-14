<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTitleInCemeteryCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cemetery_categories', function (Blueprint $table) {
            $table->renameColumn('title', 'cemetery_category_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cemetery_categories', function (Blueprint $table) {
            $table->renameColumn('cemetery_category_title', 'title');
        });
    }
}
