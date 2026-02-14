<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Porcelain extends Model
{
    protected $table = "porcelains";
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }

    public function format(){
        return $this->belongsTo(PorcelainFormat::class, 'format_id','id');
    }

    public function shape(){
        return $this->belongsTo(PorcelainShape::class,'shape_id','id');
    }

    public function size(){
        return $this->belongsTo(PorcelainSize::class,'size_id','id');
    }

    public function orientation(){
        return $this->belongsTo(PorcelainOrientation::class,'orientation_id','id');
    }

    public function part(){
        return $this->belongsTo(PorcelainPart::class,'part_id','id');
    }

    public function files(){
        return $this->hasMany(PorcelainFile::class);
    }
}
