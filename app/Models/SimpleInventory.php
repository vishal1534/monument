<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpleInventory extends Model
{
    use HasFactory;
    protected $table = 'simple_inventories';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getDateAttribute($date){
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('m/d/Y');
    }

    public function simpleInvoice(){
        return $this->hasOne(Invoice::class, 'invoice_number', 'invoice_number');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function composite()
    {
        return $this->belongsTo(Composite::class);
    }
}
