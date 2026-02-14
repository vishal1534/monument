<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdForProductInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monument_inventories', function(Blueprint $table){
            $table->unsignedBigInteger('product_id')->nullable()->after('monument_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->unsignedBigInteger('composite_id')->nullable()->after('product_id');
            $table->foreign('composite_id')->references('id')->on('composites')->onDelete('set null');
        });

        Schema::table('service_inventories', function(Blueprint $table){
            $table->unsignedBigInteger('product_id')->nullable()->after('service_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->unsignedBigInteger('composite_id')->nullable()->after('product_id');
            $table->foreign('composite_id')->references('id')->on('composites')->onDelete('set null');
        });

        Schema::table('simple_inventories', function(Blueprint $table){
            $table->unsignedBigInteger('product_id')->nullable()->after('simple_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->unsignedBigInteger('composite_id')->nullable()->after('product_id');
            $table->foreign('composite_id')->references('id')->on('composites')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monument_inventories', function(Blueprint $table){
            $table->dropForeign(['product_id']);
            $table->dropColumn(['product_id']);
            $table->dropForeign(['composite_id']);
            $table->dropColumn(['composite_id']);
        });

        Schema::table('service_inventories', function(Blueprint $table){
            $table->dropForeign(['product_id']);
            $table->dropColumn(['product_id']);
            $table->dropForeign(['composite_id']);
            $table->dropColumn(['composite_id']);
        });

        Schema::table('simple_inventories', function(Blueprint $table){
            $table->dropForeign(['product_id']);
            $table->dropColumn(['product_id']);
            $table->dropForeign(['composite_id']);
            $table->dropColumn(['composite_id']);
        });
    }
}
