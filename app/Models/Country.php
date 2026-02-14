<?php

namespace App\Models;

/*use App\Scopes\StoreIDScope;*/
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = "countries";
    protected $guarded = ['id'];

/*    protected static function booted()
    {
        static::addGlobalScope(new StoreIDScope);
    }*/
}
