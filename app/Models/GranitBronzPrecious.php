<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GranitBronzPrecious extends Model
{
    protected $table = 'granit_bronz_precious';
    protected $guarded = ['id'];

    public function flatPortrait(){
        return $this->hasOne(GranitBronzPreciousSpecification::class,'id', 'flat_portrait_id')->withDefault([
            'id' => 0,
            'oval_0'=> 0,
            'oval_1'=> 0,
            'oval_2' => 0,
            'oval_3' => 0,
            'oval_4' => 0,
            'oval_5' => 0,
            'rectangular_0' => 0,
            'rectangular_1' => 0,
            'rectangular_2' => 0,
            'rectangular_3' => 0,
            'heart_0' => 0,
            'heart_1' => 0,
            'round_0' =>0,
            'round_1' => 0
        ]);
    }

    public function flatPinnedPortrait(){
        return $this->hasOne(GranitBronzPreciousSpecification::class,'id', 'flat_pinned_portrait_id')->withDefault([
            'id' => 0,
            'oval_0'=> 0,
            'oval_1'=> 0,
            'oval_2' => 0,
            'oval_3' => 0,
            'oval_4' => 0,
            'oval_5' => 0,
            'rectangular_0' => 0,
            'rectangular_1' => 0,
            'rectangular_2' => 0,
            'rectangular_3' => 0,
            'heart_0' => 0,
            'heart_1' => 0,
            'round_0' =>0,
            'round_1' => 0
        ]);
    }

    public function flatPortraitVhbType(){
        return $this->hasOne(GranitBronzPreciousSpecification::class,'id', 'flat_portrait_vhb_type_id')->withDefault([
            'id' => 0,
            'oval_0'=> 0,
            'oval_1'=> 0,
            'oval_2' => 0,
            'oval_3' => 0,
            'oval_4' => 0,
            'oval_5' => 0,
            'rectangular_0' => 0,
            'rectangular_1' => 0,
            'rectangular_2' => 0,
            'rectangular_3' => 0,
            'heart_0' => 0,
            'heart_1' => 0,
            'round_0' =>0,
            'round_1' => 0
        ]);
    }

    public function domedPortrait(){
        return $this->hasOne(GranitBronzPreciousSpecification::class,'id', 'domed_portrait_id')->withDefault([
            'id' => 0,
            'oval_0'=> 0,
            'oval_1'=> 0,
            'oval_2' => 0,
            'oval_3' => 0,
            'oval_4' => 0,
            'oval_5' => 0,
            'rectangular_0' => 0,
            'rectangular_1' => 0,
            'rectangular_2' => 0,
            'rectangular_3' => 0,
            'heart_0' => 0,
            'heart_1' => 0,
            'round_0' =>0,
            'round_1' => 0
        ]);
    }

    public function domedPinnedPortrait(){
        return $this->hasOne(GranitBronzPreciousSpecification::class,'id', 'domed_pinned_portrait_id')->withDefault([
            'id' => 0,
            'oval_0'=> 0,
            'oval_1'=> 0,
            'oval_2' => 0,
            'oval_3' => 0,
            'oval_4' => 0,
            'oval_5' => 0,
            'rectangular_0' => 0,
            'rectangular_1' => 0,
            'rectangular_2' => 0,
            'rectangular_3' => 0,
            'heart_0' => 0,
            'heart_1' => 0,
            'round_0' =>0,
            'round_1' => 0
        ]);
    }

    public function originalFrame(){
        return $this->hasOne(GranitBronzPreciousSpecification::class,'id', 'original_frame_id')->withDefault([
            'id' => 0,
            'oval_0'=> 0,
            'oval_1'=> 0,
            'oval_2' => 0,
            'oval_3' => 0,
            'oval_4' => 0,
            'oval_5' => 0,
            'rectangular_0' => 0,
            'rectangular_1' => 0,
            'rectangular_2' => 0,
            'rectangular_3' => 0,
            'heart_0' => 0,
            'heart_1' => 0,
            'round_0' =>0,
            'round_1' => 0
        ]);
    }

    public function polishedFrame(){
        return $this->hasOne(GranitBronzPreciousSpecification::class,'id', 'polished_frame_id')->withDefault([
            'id' => 0,
            'oval_0'=> 0,
            'oval_1'=> 0,
            'oval_2' => 0,
            'oval_3' => 0,
            'oval_4' => 0,
            'oval_5' => 0,
            'rectangular_0' => 0,
            'rectangular_1' => 0,
            'rectangular_2' => 0,
            'rectangular_3' => 0,
            'heart_0' => 0,
            'heart_1' => 0,
            'round_0' =>0,
            'round_1' => 0
        ]);
    }

    public function plainColored(){
        return $this->hasOne(GranitBronzPreciousSpecification::class,'id', 'plain_colored_id')->withDefault([
            'id' => 0,
            'oval_0'=> 0,
            'oval_1'=> 0,
            'oval_2' => 0,
            'oval_3' => 0,
            'oval_4' => 0,
            'oval_5' => 0,
            'rectangular_0' => 0,
            'rectangular_1' => 0,
            'rectangular_2' => 0,
            'rectangular_3' => 0,
            'heart_0' => 0,
            'heart_1' => 0,
            'round_0' =>0,
            'round_1' => 0
        ]);
    }

    public function plainPolished(){
        return $this->hasOne(GranitBronzPreciousSpecification::class,'id', 'plain_polished_id')->withDefault([
            'id' => 0,
            'oval_0'=> 0,
            'oval_1'=> 0,
            'oval_2' => 0,
            'oval_3' => 0,
            'oval_4' => 0,
            'oval_5' => 0,
            'rectangular_0' => 0,
            'rectangular_1' => 0,
            'rectangular_2' => 0,
            'rectangular_3' => 0,
            'heart_0' => 0,
            'heart_1' => 0,
            'round_0' =>0,
            'round_1' => 0
        ]);
    }

    public function decorativeColored(){
        return $this->hasOne(GranitBronzPreciousSpecification::class,'id', 'decorative_colored_id')->withDefault([
            'id' => 0,
            'oval_0'=> 0,
            'oval_1'=> 0,
            'oval_2' => 0,
            'oval_3' => 0,
            'oval_4' => 0,
            'oval_5' => 0,
            'rectangular_0' => 0,
            'rectangular_1' => 0,
            'rectangular_2' => 0,
            'rectangular_3' => 0,
            'heart_0' => 0,
            'heart_1' => 0,
            'round_0' =>0,
            'round_1' => 0
        ]);
    }

    public function decorativePolished(){
        return $this->hasOne(GranitBronzPreciousSpecification::class,'id', 'decorative_polished_id')->withDefault([
            'id' => 0,
            'oval_0'=> 0,
            'oval_1'=> 0,
            'oval_2' => 0,
            'oval_3' => 0,
            'oval_4' => 0,
            'oval_5' => 0,
            'rectangular_0' => 0,
            'rectangular_1' => 0,
            'rectangular_2' => 0,
            'rectangular_3' => 0,
            'heart_0' => 0,
            'heart_1' => 0,
            'round_0' =>0,
            'round_1' => 0
        ]);
    }

    public function castBronzeRing(){
        return $this->hasOne(GranitBronzPreciousSpecification::class,'id', 'cast_bronze_ring_id')->withDefault([
            'id' => 0,
            'oval_0'=> 0,
            'oval_1'=> 0,
            'oval_2' => 0,
            'oval_3' => 0,
            'oval_4' => 0,
            'oval_5' => 0,
            'rectangular_0' => 0,
            'rectangular_1' => 0,
            'rectangular_2' => 0,
            'rectangular_3' => 0,
            'heart_0' => 0,
            'heart_1' => 0,
            'round_0' =>0,
            'round_1' => 0
        ]);
    }

}
