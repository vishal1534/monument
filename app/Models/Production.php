<?php

namespace App\Models;

/*use App\Scopes\StoreIDScope;*/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Production extends Model
{
    use SoftDeletes;

    protected $table = 'productions';
    protected $guarded = ['id'];

    public function getTableColumns()
    {
        // $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_productions');
        $columns = array_map(function ($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'store_id', 'order_id', 'created_at', 'updated_at', 'deleted_at']);
        $columns = array_values($columns);
        return $columns;
    }

    /*    protected static function booted()
        {
            static::addGlobalScope(new StoreIDScope);
        }*/

    public function scopeProductionDetail($query)
    {
        return $query->with([
            'order:id',
            'order.invoice:invoice_number,order_id',
            'order.installation:id,order_id',
            'order.collaboration:id,order_id'
        ]);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /* public function getFinalDateAttribute($value){
         if ($value)
         return Carbon::createFromFormat('Y-m-d', $value)->format('m/d/Y');
     }

     public function setFinalDateAttribute($value){
         if ($value)
             $this->attributes['final_date'] = (new Carbon($value))->format('Y-m-d');
     }*/
}
