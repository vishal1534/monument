<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnNameInPoProducttables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('po_producttables', function (Blueprint $table) {
            $table->renameColumn('productable_id', 'po_producttable_id');
            $table->renameColumn('productable_type', 'po_producttable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('po_producttables', function (Blueprint $table) {
            $table->renameColumn('po_producttable_id', 'productable_id');
            $table->renameColumn('po_producttable_type', 'productable_type');
        });
    }
}
