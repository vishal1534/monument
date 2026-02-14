<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'stores';
    protected $guarded = ['id'];

    public function getTableColumns() {
//        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_stores');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }
}
