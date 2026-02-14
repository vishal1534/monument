<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductEngrave extends Model
{
    protected $table = 'product_engraves';
    protected $guarded = [];

    public function getTableColumns() {
       // $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_product_engraves');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'monument_id','created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

    public function monument(){
        return $this->belongsTo(Monument::class, 'monument_id', 'id');
    }
}
