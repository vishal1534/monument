<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColorShapeSideTypeColumnsOfMonumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monuments', function (Blueprint $table) {
            $table->renameColumn('color_id', 'color');
            $table->renameColumn('shape_id', 'shape');
            $table->renameColumn('side_id', 'side');
            $table->renameColumn('type_id', 'type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monuments', function (Blueprint $table) {
            $table->renameColumn('color', 'color_id');
            $table->renameColumn('shape', 'shape_id');
            $table->renameColumn('side', 'side_id');
            $table->renameColumn('type', 'type_id');
        });
    }
}
