<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/*use App\Scopes\StoreIDScope;*/

class Quote extends Model
{

    protected $table = "quotes";
    protected $guarded = ['id'];

    public function getTableColumns() {
//        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_quotes');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['user_id','store_id', 'company_id', 'cemetery_id', 'created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

/*    protected static function booted()
    {
        static::addGlobalScope(new StoreIDScope);
    }*/

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class)->withDefault([
            'id' => 0,
            'account_number' => '',
        ]);
    }

    public function cemetery()
    {
        return $this->belongsTo(Cemetery::class)->withDefault([
            'id' => 0,
            'company' => '',
        ]);
    }

}
