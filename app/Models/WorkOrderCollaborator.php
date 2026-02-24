<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderCollaborator extends Model
{
    use HasFactory;
    protected $table = 'work_order_collaborators';
    protected $guarded = ['id'];

    public function getTableColumns()
    {
        // $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_work_order_collaborators');
        $columns = array_map(function ($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'type_id', 'work_order_id', 'is_check', 'created_at', 'updated_at', 'type_id']);
        $columns = array_values($columns);
        return $columns;
    }

    /*    protected static function booted()
        {
            static::addGlobalScope(new StoreIDScope);
        }*/

    public function type()
    {
        return $this->belongsTo(WorkOrderCollaboratorType::class, 'type_id', 'id');
    }

    // public function collaboratorCheck()
    // {
    //     return $this->hasMany(CollaborationCollaboratorCheck::class, 'collaborator_id', 'id');
    // }
}
