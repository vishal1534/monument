<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('product_specifications');

        Schema::create('product_specifications', function (Blueprint $table) {
            $table->id();
            $table->float('length', 8,2)->nullable()->comment('length in inches');
            $table->float('width', 8,2)->nullable()->comment('width in inches');
            $table->float('height', 8,2)->nullable()->comment('height in inches');
            $table->float('weight_cubic', 8,2)->nullable()->comment('cubic wight in feet');
            $table->float('cost_per_square', 8,2)->nullable()->comment('cost per square in feet');
            $table->float('square_ft_cost', 8,2)->nullable()->comment('square feet cost');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_specifications');
    }
}
