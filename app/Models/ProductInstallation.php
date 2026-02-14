<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInstallation extends Model
{
    protected $table = 'product_installation';
    protected $guarded = [];

    public function getTableColumns() {
        //$columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_product_installation');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'monument_id', 'created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }
}
