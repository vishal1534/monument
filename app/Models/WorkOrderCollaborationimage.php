<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderCollaborationImage extends Model
{
    use HasFactory;
    protected $table = 'work_order_collaboration_images';
    protected $guarded = ['id'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by', 'id');
    }

    public function getIsApprovalCheckAttribute($value)
    {
        return ((bool) $value) ? true : false;
    }

    protected function checkBoxToBoolean($value)
    {
        return ((bool) $value) ? 1 : 0;
    }

    public function setIsApprovalCheckAttribute($value)
    {
        $this->attributes['is_approval_check'] = $this->checkBoxToBoolean($value);
    }
    public function orderLogs(){
        return $this->hasMany(WorkOrderLog::class,"work_order_id");
    }
}
