<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyInLoadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loaders', function (Blueprint $table) {
            $table->foreignId('install_id')->nullable()
                ->constrained('installations')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loaders', function (Blueprint $table) {
            $table->dropForeign(['install_id']);
            $table->dropColumn('install_id');
        });
    }
}
