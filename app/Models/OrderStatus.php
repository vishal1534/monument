<?php

namespace App\Models;

/*use App\Scopes\StoreIDScope;*/

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $table = "order_statuses";
    protected $guarded = ['id'];

    public function getTableColumn()
    {
        // $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_order_statuses');
        $columns = array_map(function ($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'store_id', 'created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

    public function getOrderStatusColumn()
    {
        $columns = ['title'];
        $columns = array_values($columns);
        return $columns;
    }

    public function getOrderStatusColumns()
    {
        $column = ['title'];
        $column = array_values($column);
        return $column;
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'order_status_id', 'id');
    }

    /*    protected static function booted()
        {
            static::addGlobalScope(new StoreIDScope);
        }*/
}
