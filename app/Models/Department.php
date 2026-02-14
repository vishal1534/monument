<?php

namespace App\Models;

/*use App\Scopes\StoreIDScope;*/

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Department extends Model
{
    use Notifiable;
    protected $table = "departments";
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
    protected $casts = ['notify' => 'array'];

    public function getTableColumns() {
       // $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = DB::select('SHOW COLUMNS FROM mps_departments');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'store_id','created_at', 'updated_at','email_message','text_message','notify','notify_message','notify_email','generic']);
        $columns = array_values($columns);
        return $columns;
    }

/*    protected static function booted()
    {
        static::addGlobalScope(new StoreIDScope);
    }*/

    public function routeNotificationForMail($notification)
    {
        return 'malikusman@uforiainfotech.com';
    }

    public function routeNotificationForNexmo($notification)
    {
        return $this->phone;
    }
}
