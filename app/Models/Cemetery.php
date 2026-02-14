<?php

namespace App\Models;

/*use App\Scopes\StoreIDScope;*/
use Illuminate\Database\Eloquent\Model;

class Cemetery extends Model
{
    protected $table = "cemeteries";
    protected $guarded = ['id'];

    public function getTableColumns() {
       // $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_cemeteries');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id','store_id', 'category_id','regulation_id', 'city_id', 'county_id','state_id', 'cemetery_category_id','db_updated_date','created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

/*    protected static function booted()
    {
        static::addGlobalScope(new StoreIDScope);
    }*/

    public function regulation(){
        return $this->hasOne(CemeteryRegulation::class)->withDefault([
            'id' => 0,
            'auth_for_install' => 0,
            'auth_for_install_customer' => 0
        ]);
    }

    public function category(){
        return $this->belongsTo(CemeteryCategory::class,   'category_id', 'id');
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function county(){
        return $this->belongsTo(County::class,'county_id', 'id');
    }

    public function state(){
        return $this->belongsTo(State::class,'state_id', 'id');
    }

    public function files(){
        return $this->hasMany(CemeteryFile::class);
    }
}
