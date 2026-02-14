<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruckLoadList extends Model
{
    protected $table = "truck_load_list";
    protected $guarded = ['id'];

    public function getTableColumns() {
//        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_truck_load_list');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id','created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

    public function loader(){
        return $this->belongsTo(Loader::class);
    }

    public function truckLoadMaintenance(){
        return $this->hasOne(TruckLoadMaintenance::class);
    }

    public function truckLoadDriver(){
        return $this->hasOne(TruckLoadDriver::class);
    }

    public function truckLoadPassenger(){
        return $this->hasOne(TruckLoadPassenger::class);
    }

    public function truckLoadInside(){
        return $this->hasOne(TruckLoadInside::class);
    }

    public function truckLoadBack(){
        return $this->hasOne(TruckLoadBack::class);
    }

    public function truckLoadSetting(){
        return $this->hasOne(TruckLoadSetting::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
