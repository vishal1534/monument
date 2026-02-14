<?php

namespace App\Models;

/*use App\Scopes\StoreIDScope;*/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Composite extends Model
{
    use SoftDeletes;

    protected $table = "composites";
    protected $guarded = ['id'];

    public function getTableColumns()
    {
        //$columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_composites');
        $columns = array_map(function ($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'image', 'stocked', 'store_id', 'category_id', 'created_at', 'updated_at', 'deleted_at']);
        $columns = array_values($columns);
        return $columns;
    }

    /*    protected static function booted()
        {
            static::addGlobalScope(new StoreIDScope);
        }*/

    public function category()
    {
        return $this->belongsTo(CompositeCategory::class, 'category_id', 'id');
    }

    public function documents()
    {
        return $this->morphMany(Documents::class, 'docable');
    }

    public function files()
    {
        return $this->hasMany(CompositeFile::Class);
    }

    public function products()
    {
        return $this->morphToMany(Product::class, 'productable', 'productables', 'productable_id', 'product_id');
    }

    public function poProducts()
    {
        return $this->morphToMany(PoProduct::class, 'po_producttable', 'po_producttables', 'po_producttable_id', 'product_id');
    }

    public function memorialProducts()
    {
        return $this->morphToMany(MemorialProductionProduct::class, 'productable', 'memorial_production_productables', 'memorial_production_productable_id', 'memorial_production_product_id');
    }

    public function compositeProducts()
    {
        return $this->hasMany(CompositeProduct::class);
    }

    public function saleHistory()
    {
        return $this->hasMany(MonumentInventory::class)->latest();
    }

    public function CompositeServiceInventory()
    {
        return $this->hasMany(ServiceInventory::class)->latest();
    }

    public function CompositeSimpleInventory()
    {
        return $this->hasMany(SimpleInventory::class)->latest();
    }

    public function CompositeInventory()
    {
        return $this->hasMany(CompositeInventory::class)->latest();
    }

}
