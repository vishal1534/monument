<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_logs', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('user_id')->nullable()
                  ->constrained('users')->nullOnDelete();
            $table->foreignId('collaboration_id')->nullable()
                  ->constrained('collaborations')->nullOnDelete();
            $table->foreignId('collaboration_image_id')->nullable()
                  ->constrained('collaboration_images')->nullOnDelete();
            $table->string('log')->nullable();
            $table->string('notes')->nullable();
            $table->string('date')->nullable();
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
        Schema::dropIfExists('order_logs');
    }
}
