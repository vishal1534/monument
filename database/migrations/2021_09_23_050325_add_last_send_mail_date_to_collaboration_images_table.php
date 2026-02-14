<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastSendMailDateToCollaborationImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collaboration_images', function (Blueprint $table) {
            $table->dateTime('last_sent_mail_date', $precision = 0)->nullable()->after('sent_mail');
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
            $table->dropColumn('last_sent_mail_date');
        });
    }
}
