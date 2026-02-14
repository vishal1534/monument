<?php

namespace App\Models;

/*use App\Scopes\StoreIDScope;*/

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceWorkOrder extends Model
{
    use HasFactory;

    protected $table = "maintenance_work_orders";
    protected $guarded = ["id"];

    public function getTableColumns (){
       // $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = DB::select('SHOW COLUMNS FROM mps_maintenance_work_orders');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'store_id','work_order_completed', 'estimated_man_hours', 'perform_work_order', 'actual_man_hours', 'created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

/*    protected static function booted()
    {
        static::addGlobalScope(new StoreIDScope);
    }*/
}
