<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class ProductFreight extends Model
{
    protected $table = 'product_freights';
    protected $guarded = [];

    public function getTableColumns() {
       // $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = DB::select('SHOW COLUMNS FROM mps_product_freights');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'country_id', 'freight_come_from', 'monument_id', 'created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }
    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }

    public function monument(){
        return $this->belongsTo(Monument::class, 'monument_id', 'id');
    }
}
