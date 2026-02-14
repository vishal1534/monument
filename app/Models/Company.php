<?php

namespace App\Models;

/*use App\Scopes\StoreIDScope;*/
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = "companies";
    protected $guarded = ['id'];

    public function getTableColumns() {
       // $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_companies');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'store_id','created_at', 'updated_at', 'type', 'customer_role_id', 'company_info_type_id']);
        $columns = array_values($columns);
        return $columns;
    }

    public function getSaleReportColumn(){
        $columns = ['name'];
        $columns = array_values($columns);
        return $columns;
    }

/*    protected static function booted()
    {
        static::addGlobalScope(new StoreIDScope);
    }*/

    public function role(){
        return $this->belongsTo(CustomerRole::class, 'customer_role_id','id');
    }

    public function type(){
        return $this->belongsTo(CompanyInfoType::class, 'company_info_type_id', 'id');
    }

}
