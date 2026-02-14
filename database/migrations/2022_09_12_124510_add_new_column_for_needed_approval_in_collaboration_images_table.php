<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnForNeededApprovalInCollaborationImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collaboration_images', function (Blueprint $table) {
            $table->boolean('is_approval_check')->nullable()->after('approved_at')->default(false);
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
            $table->dropColumn('is_approval_check');
        });
    }
}
