<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallationDailyLoadList extends Model
{
    protected $table = "installation_daily_load_check_lists";
    protected $guarded = ['id'];

    public function getTableColumns() {
        //$columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_installation_daily_load_check_lists');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'user_id', 'family_id', 'invoice_id', 'company_id', 'cemetery_id', 'created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

    public function installer(){
        return $this->belongsTo(Installer::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
