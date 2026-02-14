<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NonStockProduct extends Model
{
    protected $table = 'non_stock_products';
    protected $guarded = ['id'];

    public function products(){
        return $this->morphToMany(Product::class,'productable','productables','productable_id','product_id');
    }
    public function poProducts(){
        return $this->morphToMany(PoProduct::class,'po_producttable','po_producttables','po_producttable_id','product_id');
    }
}
