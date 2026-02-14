<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompositeProduct extends Model
{
    use SoftDeletes;
    protected $table = 'composite_products';
    protected $guarded = ['id'];

    public function Monument(){
        return $this->morphedByMany(Monument::class, 'composable', 'composables','composite_id')->orderBy('composables.id', 'desc');
    }

    public function Service(){
        return $this->morphedByMany(Service::class, 'composable', 'composables','composite_id')->orderBy('composables.id', 'desc');
    }

    public function Simple(){
        return $this->morphedByMany(Simple::class, 'composable', 'composables','composite_id')->orderBy('composables.id', 'desc');
    }

}
