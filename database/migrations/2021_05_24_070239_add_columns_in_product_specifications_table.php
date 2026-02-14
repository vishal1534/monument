<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInProductSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_specifications', function (Blueprint $table) {
            $table->renameColumn('weight_cubic','weight_cubic_ft');
            $table->renameColumn('cost_per_square','cost_per_square_ft');
            $table->float('length_ft',8,2)->nullable()->default(0)->after('monument_id');
            $table->float('width_ft',8,2)->nullable()->default(0)->after('length_ft');
            $table->float('height_ft',8,2)->nullable()->default(0)->after('width_ft');
            $table->float('cubic_ft',8,2)->nullable()->default(0)->after('height_ft');
            $table->float('square_ft',8,2)->nullable()->default(0)->after('cubic_ft');
            $table->float('weight_lb',8,2)->nullable()->default(0)->after('square_ft');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_specifications', function (Blueprint $table) {
            $table->renameColumn('weight_cubic_ft', 'weight_cubic');
            $table->renameColumn('cost_per_square_ft', 'cost_per_square');
            $table->dropColumn('length_ft');
            $table->dropColumn('width_ft');
            $table->dropColumn('height_ft');
            $table->dropColumn('cubic_ft');
            $table->dropColumn('square_ft');
            $table->dropColumn('weight_lb');
        });
    }
}
