<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnStoreLocationInDeliveryWorkOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_work_order', function (Blueprint $table) {
            $table->string('store_location')->nullable()->after('other_location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_work_order', function (Blueprint $table) {
            $table->dropColumn(['store_location']);
        });
    }
}
