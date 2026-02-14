<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForiegnKeyInCemeteryRegulations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cemetery_regulations', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('cemetery_id')->after('grave_size')->nullable();
            $table->foreign('cemetery_id','cemetery_regulations_id_foreign')->references('id')->on('cemeteries')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cemetery_regulations', function (Blueprint $table) {
            //
            $table->dropForeign('cemetery_regulations_id_foreign');
        });
    }
}
