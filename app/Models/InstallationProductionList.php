<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallationProductionList extends Model
{
    protected $table = "installation_production_list";
    protected $guarded = ['id'];

    public function getTableColumns() {
        //$columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_installation_production_list');
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
