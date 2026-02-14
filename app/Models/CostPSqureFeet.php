<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostPSqureFeet extends Model
{
    use HasFactory;

    protected $table = "cost_p_squre_feets";
    protected $guarded = ['id'];

    public function getTableColumns()
    {
        $columns = ['cost_color', 'cost_type', 'granite_thickness', 'granite_sq_ft_price', 'granite_description', 'cost_vendor'];
        $columns = array_values($columns);
        return $columns;
    }

}
