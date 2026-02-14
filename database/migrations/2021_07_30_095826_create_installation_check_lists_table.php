<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallationCheckListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installation_check_lists', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('grave_flagged')->nullable();
            $table->string('installing_area_image')->nullable();
            $table->tinyInteger('installing_area_image_uploaded')->nullable();
            $table->string('before_pouring_concrete_image')->nullable();
            $table->tinyInteger('before_pouring_concrete_image_uploaded')->nullable();
            $table->string('foundation_depth')->nullable();
            $table->tinyInteger('is_issue_while_digging_foundation')->nullable();
            $table->text('digging_foundation_issues')->nullable();
            $table->string('after_pouring_concrete_image')->nullable();
            $table->tinyInteger('after_pouring_concrete_image_uploaded')->nullable();
            $table->tinyInteger('is_grass_spread')->nullable();
            $table->string('finished_installed_image')->nullable();
            $table->tinyInteger('finished_installed_image_uploaded')->nullable();
            $table->tinyInteger('grave_damaged_during_install')->nullable();
            $table->string('damaged_grave_image')->nullable();
            $table->tinyInteger('damaged_grave_image_uploaded')->nullable();
            $table->string('man_direction')->nullable();
            $table->string('woman_direction')->nullable();
            $table->string('front_monument_direction')->nullable();
            $table->string('granite_seal_or_silicon_used')->nullable();
            $table->string('vase_attached')->nullable();
            $table->string('time_arrived')->nullable();
            $table->string('time_finished')->nullable();
            $table->string('installer_name')->nullable();

            $table->bigInteger('installation_id')->unsigned()->nullable();
            $table->foreign('installation_id')->references('id')->on('installations')->onDelete('cascade');
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
        Schema::dropIfExists('installation_check_lists');
    }
}
