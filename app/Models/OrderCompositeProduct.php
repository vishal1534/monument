<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCompositeProduct extends Model
{
    use HasFactory;
    protected $table = "order_composite_products";
    protected $guarded = ["id"];

    /**
     * @todo In this table product_id is not the actual product number it is the "products" table id for creating relationship.
     */
    public function getTableColumns(){
        //$columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_order_composite_products');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id','created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }
    /**
     * @todo foreignPivotKey is the parmary key which is the child table here in my case the child table is order_composite_products and
     *  the relatedPivotKey is the primary key of parent table in my case the prent table are monument simple and service.
     */

    public function Monument(){
        return $this->morphedByMany(Monument::class, 'order_producttable', 'order_producttables','product_id')->orderBy('order_producttables.id', 'desc');
    }

    public function Service(){
        return $this->morphedByMany(Service::class, 'order_producttable', 'order_producttables','product_id')->orderBy('order_producttables.id', 'desc');
    }

    public function Simple(){
        return $this->morphedByMany(Simple::class, 'order_producttable', 'order_producttables','product_id')->orderBy('order_producttables.id', 'desc');
    }
}
