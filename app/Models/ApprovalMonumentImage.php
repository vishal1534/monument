<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalMonumentImage extends Model
{
    use HasFactory;
    protected $table = 'approval_monument_images';
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

}
