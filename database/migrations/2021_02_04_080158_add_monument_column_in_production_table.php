<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMonumentColumnInProductionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->string('production_monument_in_stock')->nullable()->after('production_type_of_order');
            $table->string('production_on_order_who')->nullable()->after('production_monument_in_stock');
            $table->string('production_vendor_proof')->nullable()->after('production_on_order_who');
            $table->string('production_on_order_in_stock')->nullable()->after('production_vendor_proof');
            $table->string('production_picture_who')->nullable()->after('production_on_order_in_stock');
            $table->string('production_picture_vendor_proof')->nullable()->after('production_picture_who');
            $table->string('production_picture_in_stock')->nullable()->after('production_picture_vendor_proof');
            $table->string('production_vase_who')->nullable()->after('production_picture_in_stock');
            $table->string('production_vase_in_stock')->nullable()->after('production_vase_who');
            $table->string('production_access_who')->nullable()->after('production_vase_in_stock');
            $table->string('production_access_in_stock')->nullable()->after('production_access_who');
            $table->string('production_rubbing_need')->nullable()->after('production_access_in_stock');
            $table->string('production_design_in_house')->nullable()->after('production_rubbing_need');
            $table->string('production_design_customer')->nullable()->after('production_design_in_house');
            $table->string('production_cemetery_approval_need')->nullable()->after('production_design_customer');
            $table->string('production_install_from_cemetery')->nullable()->after('production_cemetery_approval_need');
            $table->string('production_temp_marker_who')->nullable()->after('production_install_from_cemetery');
            $table->string('production_temp_marker_in_stock')->nullable()->after('production_temp_marker_who');
            $table->date('production_final_date')->nullable()->after('production_temp_marker_in_stock');
            $table->string('production_porcelain_made')->nullable()->after('production_final_date');
            $table->string('production_monument_make')->nullable()->after('production_porcelain_made');
            $table->string('production_paid')->nullable()->after('production_monument_make');
            $table->string('production_blast_who')->nullable()->after('production_paid');
            $table->string('production_stencil')->nullable()->after('production_blast_who');
            $table->string('production_blast_complete')->nullable()->after('production_stencil');
            $table->string('production_etch_who')->nullable()->after('production_blast_complete');
            $table->string('production_etch_complete')->nullable()->after('production_etch_who');
            $table->string('production_picture_mounted')->nullable()->after('production_etch_complete');
            $table->string('production_access_mounted')->nullable()->after('production_picture_mounted');
            $table->text('production_special_install_instructions')->nullable()->after('production_access_mounted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
