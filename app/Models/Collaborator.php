<?php

namespace App\Models;

/*use App\Scopes\StoreIDScope;*/

use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    protected $table = 'collaborators';
    protected $guarded = ['id'];

    public function getTableColumns()
    {
        // $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_collaborators');
        $columns = array_map(function ($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'store_id', 'type_id', 'collaboration_id', 'is_check', 'created_at', 'updated_at', 'type_id']);
        $columns = array_values($columns);
        return $columns;
    }

    /*    protected static function booted()
        {
            static::addGlobalScope(new StoreIDScope);
        }*/

    public function type()
    {
        return $this->belongsTo(CollaboratorType::class, 'type_id', 'id');
    }

    public function collaboratorCheck()
    {
        return $this->hasMany(CollaborationCollaboratorCheck::class, 'collaborator_id', 'id');
    }
}
