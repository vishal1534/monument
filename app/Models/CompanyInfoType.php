<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInfoType extends Model
{
    protected $table = 'company_info_type';
    protected $guarded = ['id'];
    use HasFactory;

    public function getTableColumns() {
        $columns = \DB::select('SHOW COLUMNS FROM mps_company_info_type');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }
}
