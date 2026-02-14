<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonumentFile extends Model
{
    protected $table = "monument_files";
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
}
