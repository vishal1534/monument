<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonumentAgreement extends Model
{
    protected $table = "monument_agreement";
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
