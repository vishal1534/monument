<?php

namespace App\Models;

/*use App\Scopes\StoreIDScope;*/
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collaboration extends Model
{
    use SoftDeletes;

    protected $table = 'collaborations';
    protected $guarded = ['id'];

    public function getTableColumns()
    {
        //$columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_collaborations');
        $columns = array_map(function ($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'store_id', 'order_id', 'user_id', 'created_at', 'updated_at', 'deleted_at']);
        $columns = array_values($columns);
        return $columns;
    }

    /*    protected static function booted()
        {
            static::addGlobalScope(new StoreIDScope);
        }*/

    public function scopeCollaborationDetail($query)
    {
        return $query->with([
            'order:id',
            'order.invoice:invoice_number,order_id',
            'order.installation:id,order_id',
            'order.production:id,order_id'
        ]);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function tasks()
    {
        return $this->hasMany(CollaborationTask::class)->orderBy('id', 'asc');
    }

    public function collaborators()
    {
        return $this->hasMany(Collaborator::class);
    }

    public function images()
    {
//        return $this->hasMany(CollaborationImage::class)->orderBy('id', 'desc');
        return $this->hasMany(CollaborationImage::class)->orderBy('updated_at', 'desc');
    }

    public function collaboratorMail()
    {
        return $this->hasMany(CollaboratorMail::class);
    }

    public function orderLogs()
    {
        return $this->hasMany(OrderLog::class);
    }
}
