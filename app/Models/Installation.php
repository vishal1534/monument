<?php

namespace App\Models;

/*use App\Scopes\StoreIDScope;*/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Installation extends Model
{
    use SoftDeletes;

    protected $table = "installations";
    protected $guarded = ['id'];

    public function getTableColumns(): array
    {
        //$columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_installations');
        $columns = array_map(function ($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'order_id', 'store_id', 'created_at', 'vase_direction_id', 'foundation_depth_id', 'updated_at', 'deleted_at']);
        return array_values($columns);
    }

    public function scopeInstallationDetail($query)
    {
        return $query->with([
            'order:id',
            'order.invoice:invoice_number,order_id',
            'order.collaboration:id,order_id',
            'order.production:id,order_id'
        ]);
    }

    /*    protected static function booted()
        {
            static::addGlobalScope(new StoreIDScope);
        }*/

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function checkList()
    {
        return $this->hasOne(InstallationCheckList::class)->withDefault([
            'id' => 0
        ]);
    }

    public function vaseDirection()
    {
        return $this->belongsTo(VaseDirection::class, 'vase_direction_id', 'id');
    }

    public function foundationDepth()
    {
        return $this->belongsTo(FoundationDepth::class, 'foundation_depth_id', 'id');
    }
}
