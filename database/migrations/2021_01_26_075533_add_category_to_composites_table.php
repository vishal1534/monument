<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryToCompositesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('composites', function (Blueprint $table) {
            $table->foreignId('category_id')->after('composite_name')->constrained('composite_category');
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
            $table->dropForeign('composites_category_id_foreign');
        });
    }
}
