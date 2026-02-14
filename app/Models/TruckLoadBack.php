<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruckLoadBack extends Model
{
    protected $table = "truck_load_back";
    protected $guarded = ['id'];

    public function settingDolly(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'setting_dolly_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function graniteSeal(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'granite_seal_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function shovel(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'shovel_id')->withDefault([
            'id' => 0
        ]);
    }
    public function sharpShooterShovel(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'sharp_shooter_shovel_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function hoe(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'hoe_id')->withDefault([
            'id' => 0
        ]);
    }
    public function rake(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'rake_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function pickAx(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'pick_ax_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function ftLevel4(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'ft_level_4_id')->withDefault([
            'id' => 0
        ]);
    }
    public function manualPostHoleDigger(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'manual_post_hole_digger_id')->withDefault([
            'id' => 0
        ]);
    }
    public function gasPostHoleAuger(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'gas_post_hole_auger_id')->withDefault([
            'id' => 0
        ]);
    }
    public function dingoRollerBar(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'dingo_roller_bar_id')->withDefault([
            'id' => 0
        ]);
    }
    public function craneRollerBar(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'crane_roller_bar_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function tamper(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'tamper_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function wheelBarrow(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'wheel_barrow_id')->withDefault([
            'id' => 0
        ]);
    }
    public function orangePinchBar(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'orange_pinch_bar_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function blueRoller(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'blue_roller_id')->withDefault([
            'id' => 0
        ]);
    }
    public function twoWheelChalks(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'two_wheel_chalks_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function waterBuckets(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'water_buckets_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function twoByFours(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'two_by_fours_id')->withDefault([
            'id' => 0
        ]);
    }
    public function oneByFours(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'one_by_fours_id')->withDefault([
            'id' => 0
        ]);
    }
    public function grassSeed(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'grass_seed_id')->withDefault([
            'id' => 0
        ]);
    }
    public function bucketPeaGravel(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'bucket_pea_gravel_id')->withDefault([
            'id' => 0
        ]);
    }
}
