<?php


namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;


class StoreIDScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        $storeID = Auth::user()->store_id;
        $builder->where('store_id', $storeID)->whereNotNull('store_id');
    }
}
