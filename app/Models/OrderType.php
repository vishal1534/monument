<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderType extends Model
{
    use HasFactory;

    protected $table = 'order_types';
    protected $guarded = ['id'];

    public function getTableColumn()
    {
        $columns = ['type_title'];
        $columns = array_values($columns);
        return $columns;
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'order_type_id', 'id');
    }
}
