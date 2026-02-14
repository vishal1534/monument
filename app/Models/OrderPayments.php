<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayments extends Model
{
    use HasFactory;
    protected $table = 'order_payments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_payments_date',
        'order_payments_amount'
    ];
    protected $guarded = [
        'id',
        'order_id',
        'created_at',
        'updated_at'
    ];
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','order_id');
    }
}
