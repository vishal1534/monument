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

    public function getTableColumns()
    {
        // $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = DB::select('SHOW COLUMNS FROM mps_maintenance_work_orders');
        $columns = array_map(function ($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'store_id', 'work_order_completed', 'estimated_man_hours', 'perform_work_order', 'actual_man_hours', 'created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

    public function tasks()
    {
        return $this->hasMany(WorkOrderCollaborationTask::class,"work_order_id")->orderBy('id', 'asc');
    }

    public function collaborators()
    {
        return $this->hasMany(WorkOrderCollaborator::class,"work_order_id");
    }

    public function images()
    {
        //        return $this->hasMany(CollaborationImage::class)->orderBy('id', 'desc');
        return $this->hasMany(WorkOrderCollaborationImage::class,"work_order_id")->orderBy('updated_at', 'desc');
    }

    public function collaboratorMail()
    {
        return $this->hasMany(WorkOrderCollaboratorMail::class,"work_order_id");
    }
    public function orderLogs()
    {
        return $this->hasMany(WorkOrderLog::class,"work_order_id");
    }

    public function collaboratorChecks()
    {
        return $this->hasMany(WorkOrderCollaborationCollaboratorCheck::class,"work_order_id");
    }
    public function products()
    {
        return $this->hasMany(WorkOrderProduct::class,"work_order_id");
    }
}
