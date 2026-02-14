<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accounting extends Model
{

    protected $table = "accounting";
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function getTableColumns()
    {
        //$columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_accounting');
        $columns = array_map(function ($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'order_id', 'created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

    public function getSaleReportColumn(){
        $columns = ['total_material', 'total_o_e'];
        $columns = array_values($columns);
        return $columns;
    }

    public function scopeAccountingDetail($query)
    {
        return $query->with([
            'order:id',
            'order.invoice:invoice_number,order_id',
            'order.installation:id,order_id',
            'order.production:id,order_id'
        ]);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
