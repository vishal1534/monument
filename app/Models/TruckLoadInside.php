<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruckLoadInside extends Model
{
    protected $table = "truck_load_inside";
    protected $guarded = ['id'];
    public function blackBlankets(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'black_blankets_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function rubbingPaper(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'rubbing_paper_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function jumperCabels(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'jumper_cabels_id')->withDefault([
            'id' => 0
        ]);
    }
    public function emergencyStuff(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'emergency_stuff_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function fireExt(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'fire_ext_id')->withDefault([
            'id' => 0
        ]);
    }
    public function probe(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'probe_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function installCheckList(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'install_check_list_id')->withDefault([
            'id' => 0,
        ]);
    }
    public function markingPencilWax(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'marking_pencil_wax_id')->withDefault([
            'id' => 0
        ]);
    }
    public function grayTarp(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'gray_tarp_id')->withDefault([
            'id' => 0
        ]);
    }
    public function tireRepairKit(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'tire_repair_kit_id')->withDefault([
            'id' => 0
        ]);
    }
    public function bagForDirt(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'bag_for_dirt_id')->withDefault([
            'id' => 0
        ]);
    }
    public function monumentTagsCards(){
        return $this->hasOne(TruckLoadWorkOrder::class,'id', 'monument_tags_cards_id')->withDefault([
            'id' => 0,
        ]);
    }
}
