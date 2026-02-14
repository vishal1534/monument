<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoProduct extends Model
{
    use HasFactory;

    protected $table = 'po_products';
    protected $guarded = ['id'];
    protected $casts = [
        'posted'  =>  'boolean'];

    public function NonStockProduct(){
        return $this->morphedByMany(NonStockProduct::class, 'po_producttable', 'po_producttables','product_id')->orderBy('po_producttables.id', 'desc');
    }
    public function monument(){
        return $this->morphedByMany(Monument::class, 'po_producttable', 'po_producttables', 'product_id')->orderBy('po_producttables.id', 'desc');
    }

    public function service(){
        return $this->morphedByMany(Service::class, 'po_producttable', 'po_producttables', 'product_id')->orderBy('po_producttables.id', 'desc');
    }

    public function simple(){
        return $this->morphedByMany(Simple::class, 'po_producttable', 'po_producttables', 'product_id')->orderBy('po_producttables.id', 'desc');
    }

    public function composite(){
        return $this->morphedByMany(Composite::class, 'po_producttable', 'po_producttables', 'product_id')->orderBy('po_producttables.id', 'desc');
    }
}
