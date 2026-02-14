<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = "cities";
    protected $guarded = ['id'];

    public function getTableColumns() {
        //$columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_cities');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'county_id','created_at', 'updated_at', 'state_id']);
        $columns = array_values($columns);
        return $columns;
    }

    public function county(){
        return $this->belongsTo(County::class);
    }
}
