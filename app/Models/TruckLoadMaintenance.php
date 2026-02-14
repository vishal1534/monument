<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TruckLoadMaintenance extends Model
{
    protected $table = "truck_load_maintenance";
    protected $guarded = ['id'];

    public function ckEngineOil(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'ck_engine_oil_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function ckTirePressure(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'ck_tire_pressure_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function ckOilLevel(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'ck_oil_level_id')->withDefault([
            'id' => 0,
            'fill_replace_add'=>null
        ]);
    }
}
