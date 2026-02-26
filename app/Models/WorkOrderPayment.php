<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderPayment extends Model
{
    use HasFactory;
    protected $table = "work_order_payments";
    protected $guarded = ["id"];
}
