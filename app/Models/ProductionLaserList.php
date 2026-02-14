<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionLaserList extends Model
{
    protected $table = "production_laser_list";
    protected $guarded = ['id'];

    public function getTableColumns() {
//        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_production_laser_list');
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
