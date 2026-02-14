<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovedByColumnInCollaborationImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collaboration_images', function (Blueprint $table) {
            $table->dateTime('approved_at')->change();
           });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collaboration_images', function (Blueprint $table) {
            $table->date('approved_at')->change();
        });
    }
}
