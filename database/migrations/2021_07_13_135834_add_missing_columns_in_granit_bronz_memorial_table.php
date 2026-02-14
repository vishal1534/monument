<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsInGranitBronzMemorialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('granit_bronz_memorial', function (Blueprint $table) {
            $table->string('vase_ring_no')->nullable()->after('vases');
            $table->string('vase_other')->nullable()->after('vase_ring_no');
            $table->string('scroll_type_other')->nullable()->after('scroll_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('granit_bronz_memorial', function (Blueprint $table) {
            $table->dropColumn('vase_ring_no');
            $table->dropColumn('vase_other');
            $table->dropColumn('scroll_type_other');
        });
    }
}
