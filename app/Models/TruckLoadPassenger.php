<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TruckLoadPassenger extends Model
{
    protected $table = "truck_load_passenger";
    protected $guarded = ['id'];

    public function ratchetSrtapQty11(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'ratchet_srtap_qty11_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function redSettingCushions(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'red_setting_cushions_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function whiteSettingCushions(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'white_setting_cushions_id')->withDefault([
            'id' => 0
        ]);
    }
    public function rollBluePaperTowels(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'roll_blue_paper_towels_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function blackRubberMonumentPads(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'black_rubber_monument_pads_id')->withDefault([
            'id' => 0
        ]);
    }
    public function screwDrivers(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'screw_drivers_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function Pliers(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'pliers_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function boxKnife(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'box_knife_id')->withDefault([
            'id' => 0
        ]);
    }
    public function Tape(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'tape_id')->withDefault([
            'id' => 0
        ]);
    }
    public function tubesGraySilicone(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'tubes_gray_silicone_id')->withDefault([
            'id' => 0
        ]);
    }
    public function squirtBottleColemanFull(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'squirt_bottle_coleman_full_id')->withDefault([
            'id' => 0
        ]);
    }
    public function scrubBush(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'scrub_bush_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function sprayBottleWindex(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'spray_bottle_windex_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function ftLevel2(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'ft_level2_id')->withDefault([
            'id' => 0
        ]);
    }

}
