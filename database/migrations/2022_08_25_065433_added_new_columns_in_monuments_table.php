<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddedNewColumnsInMonumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monuments', function (Blueprint $table) {
            $table->string('gi_misc_note',255)->after('supplier')->nullable();
            $table->string('gi_misc_note_a',255)->after('supplier')->nullable();
            $table->string('gi_misc_note_b',255)->after('supplier')->nullable();
            $table->string('gi_misc_note_c',255)->after('supplier')->nullable();
            $table->string('gi_misc_note_d',255)->after('supplier')->nullable();
            $table->string('gi_misc_note_e',255)->after('supplier')->nullable();
            $table->string('misc_note',255)->after('selling_price_with_installation')->nullable();
            $table->string('misc_note_a',255)->after('selling_price_with_installation')->nullable();
            $table->string('misc_note_b',255)->after('selling_price_with_installation')->nullable();
            $table->string('misc_note_c',255)->after('selling_price_with_installation')->nullable();
            $table->string('misc_note_d',255)->after('selling_price_with_installation')->nullable();
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
            $table->dropColumn('gi_misc_note');
            $table->dropColumn('gi_misc_note_a');
            $table->dropColumn('gi_misc_note_b');
            $table->dropColumn('gi_misc_note_c');
            $table->dropColumn('gi_misc_note_d');
            $table->dropColumn('gi_misc_note_e');
            $table->dropColumn('misc_note');
            $table->dropColumn('misc_note_a');
            $table->dropColumn('misc_note_b');
            $table->dropColumn('misc_note_c');
            $table->dropColumn('misc_note_d');
        });
    }
}
