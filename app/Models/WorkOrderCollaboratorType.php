<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WorkOrderCollaboratorType extends Model
{
    use HasFactory;
    protected $table = 'work_order_collaborator_types';
    protected $guarded = ['id'];

    public function getTableColumns(){
        $columns = DB::select('SHOW COLUMNS FROM mps_work_order_collaborator_types');
        $columns = array_map(function($columns){
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id','created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

/*    protected static function booted()
    {
        static::addGlobalScope(new StoreIDScope);
    }*/

    public function workOrderCollaborators(){
        return $this->hasMany(WorkOrderCollaborator::class, 'type_id');
    }
}