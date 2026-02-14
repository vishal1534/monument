<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyInCemeteryRegulation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cemetery_regulation', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('cemetery_id')->after('grave_size')->nullable();
            $table->foreign('cemetery_id','cemetery_ids_foreign')->references('id')->on('cemeteries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cemetery_regulation', function (Blueprint $table) {
            //
            $table->dropForeign('cemetery_ids_foreign');
        });
    }
}
