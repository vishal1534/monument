<?php

namespace App\Models;

/*use App\Scopes\StoreIDScope;*/

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaperLocation extends Model
{
    use HasFactory;

    protected $table = "paper_location";
    protected $guarded = ['id'];

    public function getTableColumns()
    {
        $columns = ['location_title'];
        $columns = array_values($columns);
        return $columns;
    }

    /*    protected static function booted()
        {
            static::addGlobalScope(new StoreIDScope);
        }*/
}
