<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruckLoadSetting extends Model
{
    protected $table = "truck_load_setting";
    protected $guarded = ['id'];

    public function graySiliconeQty(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'gray_silicone_qty_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function brownSiliconeQty(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'brown_silicone_qty_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function caulkGunQty(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'caulk_gun_qty_id')->withDefault([
            'id' => 0
        ]);
    }
    public function tapeMeasureQty(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'tape_measure_qty_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function torpedoLevel(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'torpedo_level_id')->withDefault([
            'id' => 0
        ]);
    }
    public function markingPaint(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'marking_paint_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function pryBar(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'pry_bar_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function Scrapers(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'scrapers_id')->withDefault([
            'id' => 0
        ]);
    }
    public function boxKnifeQty(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'box_knife_qty_id')->withDefault([
            'id' => 0
        ]);
    }
    public function blades(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'blades_id')->withDefault([
            'id' => 0
        ]);
    }
    public function handBroom(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'hand_broom_id')->withDefault([
            'id' => 0
        ]);
    }
    public function trowel(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'trowel_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function maskingTape(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'masking_tape_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function scrapers1(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'scrapers1_id')->withDefault([
            'id' => 0
        ]);
    }
    public function screwDrivers1(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'screw_drivers1_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function stringLine(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'string_line_id')->withDefault([
            'id' => 0
        ]);
    }

}
