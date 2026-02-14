<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Model
{
    use HasFactory;

    protected $table = "resources";
    protected $guarded = ["id"];

    public function getTableColumns(){
        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = array_diff($columns, ['id', 'created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }
}
