<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegualtionRealtionInCemeteries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cemeteries', function (Blueprint $table) {
            $table->unsignedBigInteger('regulation_id')->after('category_id')->nullable();
            $table->foreign('regulation_id','regulation_ids_foreign')->references('id')->on('cemetery_regulations')->onDelete('cascade');
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
            $table->dropForeign('regulation_ids_foreign');
        });
    }
}
