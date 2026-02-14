<?php

namespace App\Models;

/*use App\Scopes\StoreIDScope;*/

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = "orders";
    protected $guarded = ['id'];


    public function getTableColumns()
    {
        $columns = ['date', 'po', 'sales_person', 'sub_total', 'discount', 'is_installation', 'on_hold', 'tax_amount'];
        $columns = array_values($columns);
        return $columns;
    }

    public function getCollabColumns()
    {
        $columns = ['date', 'po', 'sales_person', 'is_installation', 'on_hold'];
        $columns = array_values($columns);
        return $columns;
    }

    public function getOrderColumn()
    {
        $columns = ['date', 'po', 'sales_person', 'sub_total', 'tax_rate', 'tax_amount', 'discount', 'on_hold_description', 'is_installation'];
        $columns = array_values($columns);
        return $columns;
    }

    /*    protected static function booted()
        {
            static::addGlobalScope(new StoreIDScope);
        }*/

    public function scopeOrderDetail($query)
    {
        return $query->with([
            'invoice:invoice_number,order_id',
            'collaboration:id,order_id',
            'installation:id,order_id',
            'production:id,order_id'
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id', 'id');
    }

    public function orderType()
    {
        return $this->belongsTo(OrderType::class, 'order_type_id', 'id');
    }

    public function paperLocation()
    {
        return $this->belongsTo(PaperLocation::class, 'paper_location_id', 'id');
    }

    public function family()
    {
        return $this->hasOne(Family::class)->withDefault([
            'id' => 0,
            'address' => ''
        ]);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class)->withDefault([
            'id' => 0
        ]);
    }

    public function cemetery()
    {
        return $this->belongsTo(Cemetery::class)->withDefault([
            'id' => 0,
            'company' => '',
            'installation_zone' => '',
            'gps' => '',
            'city' => (object)[],
            'county' => (object)[],
            'state' => (object)[]
        ]);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class)->withDefault([
            'invoice_number' => 0,
            'payments' => [],
        ]);
    }

    public function production()
    {
        return $this->hasOne(Production::class)->withDefault([
            'id' => 0,
        ]);
    }

    public function accounting()
    {
        return $this->hasOne(Accounting::class)->withDefault([
            'id' => 0,
        ]);
    }

    public function collaboration()
    {
        return $this->hasOne(Collaboration::class)->withDefault([
            'id' => 0,
        ]);
    }

    public function correspondence()
    {
        return $this->hasOne(Correspondence::class)->withDefault([
            'id' => 0,
        ]);
    }

    public function installation()
    {
        return $this->hasOne(Installation::class)->withDefault([
            'id' => 0,
        ]);
    }

    public function OrderInstallation()
    {
        return $this->hasOne(OrderInstallation::class)->withDefault([
            'id' => 0,
        ]);
    }

    public function orderForm()
    {
        return $this->hasOne(OrderForm::class)->withDefault([
            'id' => 0,
        ]);
    }

    public function brick()
    {
        return $this->hasOne(Brick::class)->withDefault([
            'id' => 0,
            'brick_1' => '',
            'brick_2' => ''
        ]);
    }

    public function granitBronzMemorial()
    {
        return $this->hasOne(GranitBronzMemorial::class)->withDefault([
            'id' => 0,
        ]);
    }

    public function granitBronzPrecious()
    {
        return $this->hasOne(GranitBronzPrecious::class)->withDefault([
            'id' => 0,
        ]);
    }

    public function monumentAgreement()
    {
        return $this->hasOne(MonumentAgreement::class)->withDefault([
            'id' => 0, 'date_promised' => null, 'option_1' => null, 'option_2' => null,
            'option_3' => null, 'option_4' => null, 'option_5' => null,
            'option_6' => null, 'option_7' => null, 'option_8' => null,
            'option_9' => null, 'option_10' => null, 'option_11' => null,
        ]);
    }

    public function monumentWorkOrder()
    {
        return $this->hasOne(MonumentWorkOrder::class)->withDefault([
            'id' => 0,
        ]);
    }

    public function finalDate()
    {
        return $this->hasOne(FinalDate::class)->withDefault([
            'id' => 0,
        ]);
    }

    public function porcelain()
    {
        return $this->hasOne(Porcelain::class)->withDefault([
            'id' => 0,
            'part_id' => null,
            'delivery_store_location_id' => null,
            'format_id' => null,
            'orientation_id' => null,
            'size_id' => null,
            'shape_id' => null
        ]);
    }

    public function monumentOrderNotes()
    {
        return $this->hasOne(MonumentOrderNotes::class)->withDefault([
            'id' => 0,
        ]);
    }

    public function deliveryWorkOrder()
    {
        return $this->hasOne(DeliveryWorkOrder::class)->withDefault([
            'id' => 0,
            'delivery_store_location_id' => null
        ]);
    }

    public function memorialProduction()
    {
        return $this->hasOne(MemorialProduction::class)->withDefault([
            'id' => 0,
        ]);
    }

    public function approvalMonument()
    {
        return $this->hasOne(ApprovalMonument::class)->withDefault([
            'id' => 0
        ]);
    }

}
