<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderCollaborationTask extends Model
{
    use HasFactory;
    protected $table = 'work_order_collaboration_tasks';
    protected $guarded = ['id'];

    public function getTableColumns()
    {
        //$columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_work_order_collaboration_tasks');
        $columns = array_map(function ($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'work_order_id', 'created_at', 'updated_at']);
        array_values($columns);
        return $columns;
    }

    public function getTaskCollaborationColumn()
    {
        $columns = ['date', 'assigned_to', 'task', 'created_by', 'close_date', 'status'];
        $columns = array_values($columns);
        return $columns;
    }

    public function scopeTaskCollaboration($query)
    {
        throw new Exception("Need to integrate at WorkOrderCollaborationTask.php---!");
        return $query->with([
            'collaboration:id,order_id',
            'collaboration.order:id',
            'collaboration.order.family:id,name_on_stone,order_id',
            'collaboration.order.invoice:invoice_number,order_id',
            'department:id,title'
        ])->whereHas('collaboration', function ($query) {
            $query->whereNull('deleted_at');
        });
    }

    public function WorkOrder()
    {
        return $this->belongsTo(MaintenanceWorkOrder::class, 'work_order_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
