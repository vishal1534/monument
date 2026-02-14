<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryStoreLocation extends Model
{
    protected $table = "delivery_store_locations";
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
