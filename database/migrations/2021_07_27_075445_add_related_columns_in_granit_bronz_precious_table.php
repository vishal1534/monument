<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelatedColumnsInGranitBronzPreciousTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('granit_bronz_precious', function (Blueprint $table) {

            $table->bigInteger('flat_portrait_id')->unsigned()->nullable()->after('order_id');
            $table->foreign('flat_portrait_id')->references('id')->on('granit_bronz_precious_specifications');

            $table->bigInteger('flat_pinned_portrait_id')->unsigned()->nullable()->after('flat_portrait_id');
            $table->foreign('flat_pinned_portrait_id')->references('id')->on('granit_bronz_precious_specifications');

            $table->bigInteger('flat_portrait_vhb_type_id')->unsigned()->nullable()->after('flat_pinned_portrait_id');
            $table->foreign('flat_portrait_vhb_type_id')->references('id')->on('granit_bronz_precious_specifications');

            $table->bigInteger('domed_portrait_id')->unsigned()->nullable()->after('flat_portrait_vhb_type_id');
            $table->foreign('domed_portrait_id')->references('id')->on('granit_bronz_precious_specifications');

            $table->bigInteger('domed_pinned_portrait_id')->unsigned()->nullable()->after('domed_portrait_id');
            $table->foreign('domed_pinned_portrait_id')->references('id')->on('granit_bronz_precious_specifications');

            $table->bigInteger('original_frame_id')->unsigned()->nullable()->after('domed_pinned_portrait_id');
            $table->foreign('original_frame_id')->references('id')->on('granit_bronz_precious_specifications');

            $table->bigInteger('polished_frame_id')->unsigned()->nullable()->after('original_frame_id');
            $table->foreign('polished_frame_id')->references('id')->on('granit_bronz_precious_specifications');

            $table->bigInteger('plain_colored_id')->unsigned()->nullable()->after('polished_frame_id');
            $table->foreign('plain_colored_id')->references('id')->on('granit_bronz_precious_specifications');

            $table->bigInteger('plain_polished_id')->unsigned()->nullable()->after('plain_colored_id');
            $table->foreign('plain_polished_id')->references('id')->on('granit_bronz_precious_specifications');

            $table->bigInteger('decorative_colored_id')->unsigned()->nullable()->after('plain_polished_id');
            $table->foreign('decorative_colored_id')->references('id')->on('granit_bronz_precious_specifications');

            $table->bigInteger('decorative_polished_id')->unsigned()->nullable()->after('decorative_colored_id');
            $table->foreign('decorative_polished_id')->references('id')->on('granit_bronz_precious_specifications');

            $table->bigInteger('cast_bronze_ring_id')->unsigned()->nullable()->after('decorative_polished_id');
            $table->foreign('cast_bronze_ring_id')->references('id')->on('granit_bronz_precious_specifications');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('granit_bronz_precious', function (Blueprint $table) {
            $table->dropForeign('flat_portrait_id');
            $table->dropColumn('flat_portrait_id');

            $table->dropForeign('flat_pinned_portrait_id');
            $table->dropColumn('flat_pinned_portrait_id');

            $table->dropForeign('flat_portrait_vhb_type_id');
            $table->dropColumn('flat_portrait_vhb_type_id');

            $table->dropForeign('domed_portrait_id');
            $table->dropColumn('domed_portrait_id');

            $table->dropForeign('domed_pinned_portrait_id');
            $table->dropColumn('domed_pinned_portrait_id');

            $table->dropForeign('original_frame_id');
            $table->dropColumn('original_frame_id');

            $table->dropForeign('polished_frame_id');
            $table->dropColumn('polished_frame_id');

            $table->dropForeign('plain_colored_id');
            $table->dropColumn('plain_colored_id');

            $table->dropForeign('plain_polished_id');
            $table->dropColumn('plain_polished_id');

            $table->dropForeign('decorative_colored_id');
            $table->dropColumn('decorative_colored_id');

            $table->dropForeign('decorative_polished_id');
            $table->dropColumn('decorative_polished_id');

            $table->dropForeign('cast_bronze_ring_id');
            $table->dropColumn('cast_bronze_ring_id');
        });
    }
}
