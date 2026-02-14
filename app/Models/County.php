<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    protected $table = "counties";
    protected $guarded = ['id'];

    public function getTableColumns() {
      //  $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_counties');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'state_id','created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function cities(){
        return $this->hasMany(City::class, "county_id");
    }
}
