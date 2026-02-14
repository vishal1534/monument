<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceFile extends Model
{
    protected $table = "service_files";
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
}
