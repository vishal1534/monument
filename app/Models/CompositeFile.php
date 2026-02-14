<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompositeFile extends Model
{
    protected $table = "composite_files";
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
}
