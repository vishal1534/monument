<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTablesName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename("product_engrave", "product_engraves");
        Schema::rename("product_freight_cost", "product_freights");
        Schema::rename("product_polish", "product_polishes");
        Schema::rename("product_color", "product_colors");
        Schema::rename("product_shape", "product_shapes");
        Schema::rename("product_side", "product_sides");
        Schema::rename("product_type", "product_types");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename("product_engraves","product_engrave");
        Schema::rename("product_freights", "product_freight_cost");
        Schema::rename("product_polishes","product_polish");
        Schema::rename("product_colors", "product_color");
        Schema::rename("product_shapes", "product_shape");
        Schema::rename("product_sides", "product_side");
        Schema::rename("product_types", "product_type");

    }
}
