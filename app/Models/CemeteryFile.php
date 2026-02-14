<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CemeteryFile extends Model
{

    protected $table = 'cemetery_files';
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
}
