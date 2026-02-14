<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionOcPictureList extends Model
{
    protected $table = "production_oc_picture_list";
    protected $guarded = ['id'];

    public function getTableColumns() {
//        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_production_oc_picture_list');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
