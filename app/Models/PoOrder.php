<?php

namespace App\Models;

/*use App\Scopes\StoreIDScope;*/

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoOrder extends Model
{
    use HasFactory;

    protected $table = 'po_orders';
    protected $guarded = ['id'];

    public function getTableColumns(){
        //$columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = DB::select('SHOW COLUMNS FROM mps_po_orders');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'store_id','supplier_id', 'created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

/*    protected static function booted()
    {
        static::addGlobalScope(new StoreIDScope);
    }*/

    public function poProducts(){
        return $this->hasMany(PoProduct::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
}
