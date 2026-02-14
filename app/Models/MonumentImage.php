<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonumentImage extends Model
{
    protected $table = "monument_images";
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
}
