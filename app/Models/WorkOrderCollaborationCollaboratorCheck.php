<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderCollaborationCollaboratorCheck extends Model
{
    use HasFactory;
    protected $table = 'work_order_collaboration_collaborator_checks';
    protected $guarded = ['id'];

    public function type()
    {
        return $this->belongsTo(WorkOrderCollaboratorType::class, 'type_id', 'id');
    }
}
