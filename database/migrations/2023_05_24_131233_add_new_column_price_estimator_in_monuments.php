<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnPriceEstimatorInMonuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monuments', function (Blueprint $table) {
            $table->string('price_estimator')->nullable()->after('store_id');
            $table->string('reference_id')->nullable()->after('store_id');
            $table->foreignId('quote_id')->nullable()->after('store_id')
                ->constrained('quotes')->nullOnDelete();
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
            $table->dropColumn('price_estimator');
            $table->dropColumn('reference_id');
            $table->dropForeign(['quote_id']);
            $table->dropColumn('quote_id');
        });
    }
}
