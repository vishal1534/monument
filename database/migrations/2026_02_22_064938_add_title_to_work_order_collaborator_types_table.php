<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleToWorkOrderCollaboratorTypesTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('work_order_collaborator_types')) {

            if (!Schema::hasColumn('work_order_collaborator_types', 'title')) {

                Schema::table('work_order_collaborator_types', function (Blueprint $table) {
                    $table->string('title')->after('id');
                });

            }
        }
    }

    public function down()
    {
        if (Schema::hasTable('work_order_collaborator_types')) {

            if (Schema::hasColumn('work_order_collaborator_types', 'title')) {

                Schema::table('work_order_collaborator_types', function (Blueprint $table) {
                    $table->dropColumn('title');
                });

            }
        }
    }
}