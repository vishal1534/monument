<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompositeInventory extends Model
{
    use HasFactory;
    protected $table = 'composite_inventories';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function composite()
    {
        return $this->belongsTo(Composite::class);
    }

    public function compositeInvoice(){
        return $this->hasOne(Invoice::class, 'invoice_number', 'invoice_number');
    }
}
