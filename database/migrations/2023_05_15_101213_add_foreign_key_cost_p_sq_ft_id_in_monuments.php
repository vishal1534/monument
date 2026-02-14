<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyCostPSqFtIdInMonuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monuments', function (Blueprint $table) {
            $table->foreignId('cost_p_squ_ft_id')->nullable()->after('side_id')
                ->constrained('cost_p_squre_feets')->nullOnDelete();
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
            $table->dropForeign(['cost_p_squ_ft_id']);
            $table->dropColumn('cost_p_squ_ft_id');
        });
    }
}
