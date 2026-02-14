<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    protected $table = "invoice_payments";
    protected $guarded = ['id'];

    public function getTableColumns() {
       // $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = \DB::select('SHOW COLUMNS FROM mps_invoice_payments');
        $columns = array_map(function($columns) {
            return $columns->Field;
        }, $columns);
        $columns = array_diff($columns, ['id', 'invoice_id', 'created_at', 'updated_at']);
        $columns = array_values($columns);
        return $columns;
    }

    public function invoice(){
        return $this->belongsTo(Invoice::class)->withDefault([
            'id' => 0,
            'amount' => ''
        ]);
    }
}
