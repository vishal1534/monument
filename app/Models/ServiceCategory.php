<?php

namespace App\Models;

/*use App\Scopes\StoreIDScope;*/

use DB;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $table = "service_category";
    protected $guarded = ['id'];

    public function getTableColumns() {
//        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = DB::select('SHOW COLUMNS FROM mps_service_category');
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

    public function services(){
        return $this->hasMany(Service::class);
    }
}
