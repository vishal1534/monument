<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorrespondenceTask extends Model
{
    protected $table = 'correspondence_tasks';
    protected $guarded = ['id'];

    public function getTableColumns()
    {
        //$columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_correspondence_tasks');
        $columns = array_map(function ($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'correspondence_id', 'created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

    public function scopeTaskCorrespondence($query)
    {
        return $query->with([
            'correspondence:id,order_id',
            'correspondence.order:id',
            'correspondence.order.family:id,name_on_stone,order_id',
            'correspondence.order.invoice:invoice_number,order_id',
        ])->whereHas('correspondence.order', function ($query) {
            $query->whereNull('deleted_at');
        });
    }

    public function getTaskCorrespondence(){
        $columns = ['date', 'who_corsp', 'form_of_communication', 'why_contacted', 'customer_reasons', 'notes', 'contact_name'];
        $columns = array_values($columns);
        return $columns;
    }

    public function correspondence()
    {
        return $this->belongsTo(Correspondence::class);
    }
}
