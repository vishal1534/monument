<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalMonument extends Model
{
    protected $table = "approval_monument";
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }

    public function image(){
        return $this->hasMany(ApprovalMonumentImage::class, 'approval_monument_id', 'id');
    }
}
