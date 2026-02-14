<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlagInCollaborationImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collaboration_images', function (Blueprint $table) {
            $table->tinyInteger('sent_mail')->after('status')->default(0);
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
            $table->dropColumn('sent_mail');
        });
    }
}
