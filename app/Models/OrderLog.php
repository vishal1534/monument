<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLog extends Model
{
    use HasFactory;

    protected $guarded = ['created_at', 'updated_at'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
