<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correspondence extends Model
{
    protected $table = 'correspondences';
    protected $guarded = ['id'];

    public function getTableColumns() {
       // $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_correspondences');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'order_id', 'created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function tasks(){
        return $this->hasMany(CorrespondenceTask::class)->orderBy('id','asc');
    }
}
