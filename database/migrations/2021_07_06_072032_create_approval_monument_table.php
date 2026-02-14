<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalMonumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_monument', function (Blueprint $table) {
            $table->id();
            $table->string('approved_by')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('image_front')->nullable();
            $table->string('image_back')->nullable();
            $table->tinyInteger('granite_color')->nullable()->comment('0 for gray,
            1 for Ml.BLK, 2 for D.BROWN, 3 for M.ROSE, 4 for BAHAMA BLUE, 
            5 for BLUE PEARL, 6 for INDIA RED, 7 for Other');
            $table->tinyInteger('carving_style')->nullable()->comment('0 for FLAT CURVE,
            1 for SHAPE CURVE, 2 for LASER ETCH, 3 for HAND ETCH');
            $table->tinyInteger('letter_style')->nullable()->comment('0 for V-CUT,
            1 for SKIN SUNK, 2 for FROSTED OUTLINE, 3 for Other');
            $table->tinyInteger('lithochrome_agent')->nullable()->comment('0 for BLACK,
            1 for LT.HI-LITE, 2 for MED HI-LITE, 3 for HEAVY HI-LITE');
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
        Schema::dropIfExists('approval_monument');
    }
}
