<?php

namespace App\Models;

/*use App\Scopes\StoreIDScope;*/
use Illuminate\Database\Eloquent\Model;

class Loader extends Model
{
    protected $table = "loaders";
    protected $guarded = ['id'];

    public function getTableColumns() {
       // $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_loaders');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id','store_id', 'install_id', 'sign_of_checker','sign_of_installer', 'created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

/*    protected static function booted()
    {
        static::addGlobalScope(new StoreIDScope);
    }*/

    public function truckLoadList(){
        return $this->hasOne(TruckLoadList::class);
    }
}
