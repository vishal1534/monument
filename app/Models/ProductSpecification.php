<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSpecification extends Model
{
    protected $table = 'product_specifications';
    protected $guarded = [];

    public function getTableColumns() {
//        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_product_specifications');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'monument_id','created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

    public function monument(){
        return $this->belongsTo(Monument::class, 'monument_id', 'id');
    }

    /**
     * Set length
     *
     * @param  string|int  $value
     * @return void
     */
    public function setLengthAttribute($value)
    {
        $this->attributes['length'] = ($value == '' ? NULL : $value);
    }

    /**
     * Set width
     *
     * @param  string|int  $value
     * @return void
     */
    public function setWidthAttribute($value)
    {
        $this->attributes['width'] = ($value == '' ? NULL : $value);
    }

    /**
     * Set weight cubic ft
     *
     * @param  string|int  $value
     * @return void
     */
    public function setWeightCubicFtAttribute($value)
    {
        $this->attributes['weight_cubic_ft'] = ($value == '' ? NULL : $value);
    }
}
