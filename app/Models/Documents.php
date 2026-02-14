<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    protected $table = 'documents';
    protected $guarded = ['id'];

    public function productable()
    {
        return $this->morphTo();
    }
}
