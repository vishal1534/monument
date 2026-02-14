<?php

namespace App\Models;

/*use App\Scopes\StoreIDScope;*/

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonumentPolish extends Model
{
    use HasFactory;
    protected $table = "monument_polish";
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function getTableColumns() {
        //$columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = DB::select('SHOW COLUMNS FROM mps_monument_polish');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id','store_id', 'created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

/*    protected static function booted()
    {
        static::addGlobalScope(new StoreIDScope);
    }*/
}
