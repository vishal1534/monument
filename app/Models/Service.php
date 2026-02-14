<?php

namespace App\Models;

/*use App\Scopes\StoreIDScope;*/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{

    use SoftDeletes;

    protected $table = "services";
    protected $guarded = ['id'];

    public function getTableColumns()
    {
//        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_services');
        $columns = array_map(function ($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'image', 'store_id', 'category_id', 'created_at', 'updated_at', 'deleted_at']);
        $columns = array_values($columns);
        return $columns;
    }

    /*    protected static function booted()
        {
            static::addGlobalScope(new StoreIDScope);
        }*/

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id', 'id');
    }

    public function products()
    {
        return $this->morphToMany(Product::class, 'productable', 'productables', 'productable_id', 'product_id');
    }

    public function poProducts()
    {
        return $this->morphToMany(PoProduct::class, 'po_producttable', 'po_producttables', 'po_producttable_id', 'product_id');
    }

    public function compositeProducts()
    {
        return $this->morphToMany(CompositeProduct::class, 'composable', 'composables', 'composable_id', 'composite_id');
    }

    public function memorialProducts()
    {
        return $this->morphToMany(MemorialProductionProduct::class, 'productable', 'memorial_production_productables', 'memorial_production_productable_id', 'memorial_production_product_id');
    }

    public function serviceInventory()
    {
        return $this->hasMany(ServiceInventory::class)->whereNotNull(['total', 'qty_add_or_remove'])->latest();
    }

    public function saleHistory()
    {
        return $this->hasMany(ServiceInventory::class)->whereNotNull(['invoice_number', 'item_order'])->latest();
    }

    public function files()
    {
        return $this->hasMany(ServiceFile::class);
    }

    public function images()
    {
        return $this->hasMany(ServiceImage::class);
    }
}
