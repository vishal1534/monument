<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnNamesInServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('service_number', 'product_number');
            $table->renameColumn('service_name', 'item_name');
            $table->renameColumn('service_description', 'description');
            $table->renameColumn('service_price', 'price');
            $table->renameColumn('service_image', 'image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('product_number','service_number');
            $table->renameColumn('item_name','service_name');
            $table->renameColumn('description','service_description');
            $table->renameColumn('price','service_price');
            $table->renameColumn('image','service_image');
        });
    }
}
