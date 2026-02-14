<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpleFile extends Model
{
    protected $table = "simple_files";
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
}
