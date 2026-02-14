<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStoreIdInAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('collaborations', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('productions', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('installations', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('cemeteries', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('monuments', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('simples', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('composites', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('collaborators', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('collaborator_types', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('product_colors', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('product_types', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('product_shapes', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('product_sides', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('monument_polish', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('service_category', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('simple_categories', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('composite_category', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('production_oc_pictures', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('production_sandblastings', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('production_lasers', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('weekly_schedules', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('installers', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('loaders', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('installation_productions', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('po_orders', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('equipments', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('maintenance_work_orders', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('order_statuses', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });

        Schema::table('paper_location', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()
                ->constrained('stores')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('collaborations', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('productions', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('installations', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('cemeteries', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('monuments', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('simples', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('composites', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('collaborators', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('collaborator_types', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('product_colors', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('product_types', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('product_shapes', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('product_sides', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('monument_polish', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('service_category', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('simple_categories', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('composite_category', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('production_oc_pictures', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('production_sandblastings', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('production_lasers', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('weekly_schedules', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('installers', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });


        Schema::table('loaders', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('installation_productions', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('po_orders', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('equipments', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('maintenance_work_orders', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('order_statuses', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('paper_location', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

    }
}
