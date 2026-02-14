<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalDate extends Model
{
    protected $table = "final_date";
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }
}
