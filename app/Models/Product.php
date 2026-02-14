<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';
    protected $guarded = ['id'];

    public function NonStockProduct(){
        return $this->morphedByMany(NonStockProduct::class, 'productable', 'productables','product_id')->orderBy('productables.id', 'desc');
    }

    public function Monument(){
        return $this->morphedByMany(Monument::class, 'productable', 'productables','product_id')->orderBy('productables.id', 'desc');
    }

    public function Service(){
        return $this->morphedByMany(Service::class, 'productable', 'productables','product_id')->orderBy('productables.id', 'desc');
    }

    public function Simple(){
        return $this->morphedByMany(Simple::class, 'productable', 'productables','product_id')->orderBy('productables.id', 'desc');
    }

    public function Composite(){
        return $this->morphedByMany(Composite::class, 'productable', 'productables','product_id')->orderBy('productables.id', 'desc');
    }

    public function OrderCompositeProduct(){
        return $this->hasMany(OrderCompositeProduct::class);
    }

    public function QuoteCompositeProduct(){
        return $this->hasMany(QuoteCompositeProduct::class);
    }

    public function MonumentInventory()
    {
        return $this->hasMany(MonumentInventory::class);
    }

    public function ServiceInventory()
    {
        return $this->hasMany(ServiceInventory::class);
    }

    public function SimpleInventory()
    {
        return $this->hasMany(SimpleInventory::class);
    }

    public function CompositeInventory()
    {
        return $this->hasOne(CompositeInventory::class);
    }
}
