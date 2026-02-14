<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryWorkOrder extends Model
{
    protected $table = "delivery_work_order";
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
