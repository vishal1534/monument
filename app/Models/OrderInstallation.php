<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderInstallation extends Model
{
    protected $table = "order_installations";
    protected $guarded = ['id'];

    public function getTableColumns(): array
    {
        //$columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_order_installations');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'order_id',  'created_at', 'updated_at']);
        return array_values($columns);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function Monument(){
        return $this->hasOne(InstallationMonument::class)->withDefault([
            'id' => 0
        ]);
    }

    public function Flagging(){
        return $this->hasOne(InstallationFlagging::class)->withDefault([
            'id' => 0
        ]);
    }

    public function Placement(){
        return $this->hasOne(InstallationPlacement::class)->withDefault([
            'id' => 0
        ]);
    }

    public function Payment(){
        return $this->hasOne(InstallationPayment::class)->withDefault([
            'id' => 0
        ]);
    }

    public function CemeteryConfirmation(){
        return $this->hasOne(InstallationCemeteryConfirmation::class)->withDefault([
            'id' => 0
        ]);
    }

}
