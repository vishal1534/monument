<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsNameOfMonumentsServiceAndSimple extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monuments', function (Blueprint $table){
            $table->renameColumn('gi_misc_note_a', 'indep');
            $table->renameColumn('gi_misc_note_b', 'clinton');
            $table->renameColumn('gi_misc_note_c', 'ex_spring');
            $table->renameColumn('gi_misc_note_d', 'ph');
            $table->renameColumn('gi_misc_note_e', 'bs');
        });

        Schema::table('services', function (Blueprint $table){
            $table->renameColumn('gi_misc_note_a', 'indep');
            $table->renameColumn('gi_misc_note_b', 'clinton');
            $table->renameColumn('gi_misc_note_c', 'ex_spring');
            $table->renameColumn('gi_misc_note_d', 'ph');
            $table->renameColumn('gi_misc_note_e', 'bs');
        });

        Schema::table('simples', function(Blueprint $table){
            $table->renameColumn('gi_misc_note_a', 'indep');
            $table->renameColumn('gi_misc_note_b', 'clinton');
            $table->renameColumn('gi_misc_note_c', 'ex_spring');
            $table->renameColumn('gi_misc_note_d', 'ph');
            $table->renameColumn('gi_misc_note_e', 'bs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monuments', function (Blueprint $table){
            $table->renameColumn('indep','gi_misc_note_a');
            $table->renameColumn('clinton','gi_misc_note_b');
            $table->renameColumn('ex_spring','gi_misc_note_c');
            $table->renameColumn('ph','gi_misc_note_d');
            $table->renameColumn('bs','gi_misc_note_e');
        });

        Schema::table('services', function(Blueprint $table){
            $table->renameColumn('indep','gi_misc_note_a');
            $table->renameColumn('clinton','gi_misc_note_b');
            $table->renameColumn('ex_spring','gi_misc_note_c');
            $table->renameColumn('ph','gi_misc_note_d');
            $table->renameColumn('bs','gi_misc_note_e');
        });

        Schema::table('simples', function (Blueprint $table){
            $table->renameColumn('indep','gi_misc_note_a');
            $table->renameColumn('clinton','gi_misc_note_b');
            $table->renameColumn('ex_spring','gi_misc_note_c');
            $table->renameColumn('ph','gi_misc_note_d');
            $table->renameColumn('bs','gi_misc_note_e');
        });
    }
}
