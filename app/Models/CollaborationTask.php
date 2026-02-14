<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollaborationTask extends Model
{
    protected $table = 'collaboration_tasks';
    protected $guarded = ['id'];

    public function getTableColumns()
    {
        //$columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_collaboration_tasks');
        $columns = array_map(function ($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'collaboration_id', 'created_at', 'updated_at']);
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

    public function collaboration()
    {
        return $this->belongsTo(Collaboration::class, 'collaboration_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
