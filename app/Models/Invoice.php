<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = "invoices";
    protected $primaryKey = 'invoice_number';
    protected $guarded = ['invoice_number'];

    public function getTableColumns()
    {
        $columns = ['invoice_number','closed_date','ship_date','date_promised','invoice_total'];
        $columns = array_values($columns);
        return $columns;
    }

    public function getInvoiceColumn()
    {
        $columns = ['invoice_number', 'original_invoice_number', 'closed_date', 'ship_date', 'date_promised', 'invoice_total'];
        $columns = array_values($columns);
        return $columns;
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(InvoicePayment::class, 'invoice_id', 'invoice_number');
    }

    public function monumentInventory()
    {
        return $this->hasMany(MonumentInventory::class, 'invoice_number', 'invoice_number')->whereNotNull(['invoice_number', 'item_order']);
    }

    public function simpleInventory()
    {
        return $this->hasMany(SimpleInventory::class, 'invoice_number', 'invoice_number')->whereNotNull(['invoice_number', 'item_order']);
    }

    public function serviceInventory()
    {
        return $this->hasMany(ServiceInventory::class, 'invoice_number', 'invoice_number')->whereNotNull(['invoice_number', 'item_order']);
    }
}
