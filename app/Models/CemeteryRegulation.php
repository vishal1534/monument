<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CemeteryRegulation extends Model
{
    protected $table = "cemetery_regulations";
    protected $guarded = ['id'];

    public function getTableColumns() {
        //$columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_cemetery_regulations');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'cemetery_id','created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

    public function cemetery(){
        return $this->belongsTo(Cemetery::class);
    }
}
