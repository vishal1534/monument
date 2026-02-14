<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruckLoadDriver extends Model
{
    protected $table = "truck_load_driver";
    protected $guarded = ['id'];

    public function comeAlong(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'come_along_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function rollRope(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'roll_rope_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function xtraStraps(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'xtra_straps_id')->withDefault([
            'id' => 0
        ]);
    }
    public function flashLight(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'flash_light_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function crowBar(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'crow_bar_id')->withDefault([
            'id' => 0
        ]);
    }
    public function sledge(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'sledge_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function hatchet(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'hatchet_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function craneControl(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'crane_control_id')->withDefault([
            'id' => 0
        ]);
    }
    public function blueToolBox(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'blue_tool_box_id')->withDefault([
            'id' => 0
        ]);
    }
    public function cableLock(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'cable_lock_id')->withDefault([
            'id' => 0
        ]);
    }
    public function d2Sprayer(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'd_2_sprayer_id')->withDefault([
            'id' => 0
        ]);
    }
}
