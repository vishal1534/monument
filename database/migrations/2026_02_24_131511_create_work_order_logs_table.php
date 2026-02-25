<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrderLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()
                  ->constrained('users')->nullOnDelete();
            $table->foreignId('work_order_id')->nullable()
                  ->constrained('maintenance_work_orders')->nullOnDelete();
            $table->foreignId('collaboration_image_id')->nullable()
                  ->constrained('work_order_collaboration_images')->nullOnDelete();
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
        Schema::dropIfExists('work_order_logs');
    }
}
