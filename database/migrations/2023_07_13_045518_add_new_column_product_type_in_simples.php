<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnProductTypeInSimples extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('simples', function (Blueprint $table) {
            $table->string('product_type')->nullable()->default('Simple');
        });
        \DB::table('simples')
            ->update(['product_type' => 'Simple']);

        Schema::table('services', function (Blueprint $table) {
            $table->string('product_type')->nullable()->default('Service');
        });
        \DB::table('services')
            ->update(['product_type' => 'Service']);

        Schema::table('monuments', function (Blueprint $table) {
            $table->string('product_type')->nullable()->default(null);
        });
        \DB::table('monuments')->whereNull('price_estimator')
            ->update(['product_type' => 'Monument']);

        \DB::table('monuments')->whereNotNull('price_estimator')
            ->update(['product_type' => 'Price Estimator']);

        Schema::table('composites', function (Blueprint $table) {
            $table->string('product_type')->nullable()->default('Composite');
        });
        \DB::table('composites')
            ->update(['product_type' => 'Composite']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('simples', function (Blueprint $table) {
            $table->dropColumn('product_type');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('product_type');
        });

        Schema::table('monuments', function (Blueprint $table) {
            $table->dropColumn('product_type');
        });

        Schema::table('composites', function (Blueprint $table) {
            $table->dropColumn('product_type');
        });
    }
}
