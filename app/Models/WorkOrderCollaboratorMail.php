<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderCollaboratorMail extends Model
{
    use HasFactory;
    protected $table = 'work_order_collaborator_mails';
    protected $guarded = ['id'];

    public function getTableColumn(){
        $columns = \DB::select('SHOW COLUMNS FROM mps_work_order_collaborator_mails');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }
}
