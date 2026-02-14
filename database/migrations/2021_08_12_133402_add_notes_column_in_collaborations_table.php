<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotesColumnInCollaborationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collaborations', function (Blueprint $table) {

            $table->dropColumn('order_status');
            $table->dropColumn('paper_location');
            $table->dropColumn('order_on_hand');
            $table->dropColumn('order_on_hand_description');
            $table->text('notes')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collaborations', function (Blueprint $table) {
            $table->string('order_status')->nullable();
            $table->string('paper_location')->nullable();
            $table->string('order_on_hand')->nullable();
            $table->string('order_on_hand_description')->nullable();
            $table->dropColumn('notes');
        });
    }
}
