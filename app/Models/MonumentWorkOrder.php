<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonumentWorkOrder extends Model
{
    protected $table = "monument_work_order";
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
