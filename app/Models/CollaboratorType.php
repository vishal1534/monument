<?php

namespace App\Models;

/*use App\Scopes\StoreIDScope;*/

use DB;
use Illuminate\Database\Eloquent\Model;

class CollaboratorType extends Model
{
    protected $table = 'collaborator_types';
    protected $guarded = ['id'];

    public function getTableColumns(){
        $columns = DB::select('SHOW COLUMNS FROM mps_collaborator_types');
        $columns = array_map(function($columns){
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id','store_id','created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

/*    protected static function booted()
    {
        static::addGlobalScope(new StoreIDScope);
    }*/

    public function collaborators(){
        return $this->hasMany(Collaboration::class, 'type_id');
    }
}
