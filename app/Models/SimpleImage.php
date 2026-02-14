<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpleImage extends Model
{
    protected $table = "simple_images";
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
}
