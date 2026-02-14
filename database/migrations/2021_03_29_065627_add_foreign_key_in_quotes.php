<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyInQuotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->unsignedBigInteger('store_id')->nullable();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('set null');
//            $table->foreign('store_id','quote_store_id_foreign')->references('id')->on('stores')->onDelete('cascade');
            $table->unsignedBigInteger('cemetery_id')->nullable();
            $table->foreign('cemetery_id','quote_cemetery_id_foreign')->references('id')->on('cemeteries')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropForeign('quote_store_id_foreign');
            $table->dropForeign('quote_cemetery_id_foreign');
        });
    }
}
