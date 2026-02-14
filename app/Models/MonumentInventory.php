<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonumentInventory extends Model
{
    use HasFactory;
    protected $table = "monument_inventories";
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function monumentInvoice(){
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
