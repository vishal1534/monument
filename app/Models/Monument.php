<?php

namespace App\Models;


/*use App\Scopes\StoreIDScope;*/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Monument extends Model
{

    use SoftDeletes;

    protected $table = "monuments";
    protected $guarded = ['id'];

    public function getTableColumns()
    {
        /**
         * TODO :
         * comment schema builder because database schema builder is not coorect.
         * after adding a new migration schema builder is creating problem that is column name are
         * in sorted format.
         * 'ORDER BY ORDINAL_POSITION'
         */
        // $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_monuments');
        $columns = array_map(function ($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'store_id', 'image', 'cost_p_squ_ft_id', 'monument_polish_id', 'color_id', 'shape_id', 'type_id', 'side_id', 'created_at', 'updated_at', 'deleted_at']);
        $columns = array_values($columns);
        return $columns;
    }

    /*    protected static function booted()
        {
            static::addGlobalScope(new StoreIDScope);
        }*/


    public function getOverrideSellingPriceAttribute($value)
    {
        return $value ?? 0;
    }

    public function specification()
    {
        return $this->hasOne(ProductSpecification::class, 'monument_id', 'id');
    }

    public function polish()
    {
        return $this->hasOne(ProductPolish::class);
    }

    public function engrave()
    {
        return $this->hasOne(ProductEngrave::class);
    }

    public function freight()
    {
        return $this->hasOne(ProductFreight::class);
    }

    public function installation()
    {
        return $this->hasOne(ProductInstallation::class);
    }

    public function color()
    {
        return $this->belongsTo(ProductColor::class, 'color_id', 'id');
    }

    public function shape()
    {
        return $this->belongsTo(ProductShape::class, 'shape_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(ProductType::class, 'type_id', 'id');
    }

    public function side()
    {
        return $this->belongsTo(ProductSide::class, 'side_id', 'id');
    }

    public function monumentPolish()
    {
        return $this->belongsTo(MonumentPolish::class);
    }

    public function documents()
    {
        return $this->morphMany(Documents::class, 'docable');
    }

    public function files()
    {
        return $this->hasMany(MonumentFile::Class);
    }

    public function images()
    {
        return $this->hasMany(MonumentImage::class);
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

    public function monumentInventory()
    {
        return $this->hasMany(MonumentInventory::class)->whereNotNull(['total', 'qty_add_or_remove'])->latest();
    }

    public function saleHistory()
    {
        return $this->hasMany(MonumentInventory::class)->whereNotNull(['invoice_number', 'item_order'])->latest();
    }

    /**
     * Set total on hand
     *
     * @param string|int $value
     *
     * @return void
     */
    public function setTotalOnHandAttribute($value)
    {
        $this->attributes['total_on_hand'] = ($value == '' ? NULL : $value);
    }

    /**
     * Set total sold
     *
     * @param string|int $value
     *
     * @return void
     */
    public function setTotalSoldAttribute($value)
    {
        $this->attributes['total_sold'] = ($value == '' ? NULL : $value);
    }

    /**
     * Set quantity stocked
     *
     * @param string|int $value
     *
     * @return void
     */
    public function setQuantityStockedAttribute($value)
    {
        $this->attributes['quantity_stocked'] = ($value == '' ? NULL : $value);
    }

    /**
     * Set total added
     *
     * @param string|int $value
     *
     * @return void
     */
    public function setTotalAddedAttribute($value)
    {
        $this->attributes['total_added'] = ($value == '' ? NULL : $value);
    }

    /**
     * Set selling formula
     *
     * @param string|int $value
     *
     * @return void
     */
    public function setSellingFormulaAttribute($value)
    {
        $this->attributes['selling_formula'] = ($value == '' ? NULL : $value);
    }
}
