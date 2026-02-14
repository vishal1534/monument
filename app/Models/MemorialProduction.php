<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemorialProduction extends Model
{
    protected $table = "memorial_productions";
    protected $guarded = ['id'];
    protected $casts = ['design_carving_styles' => 'array',
        'darkening_agents' => 'array',
        'whitening_agents' => 'array',
        'no_panels' => 'array',
        'single_line_panels' => 'array',
        'double_line_panels' => 'array',
        'other_first_panels' => 'array',
        'other_second_panels' => 'array',
        'cqc_script_lettering' => 'array',
        'govt_text_lettering' => 'array',
        'modified_roman_lettering' => 'array',
        'runstone_lettering' => 'array',
        'connected_script_lettering' => 'array',
        'helvetica_lettering' => 'array',
        'opti_sb_lettering' => 'array',
        'vermarco_lettering' => 'array',
        'common_gothic_lettering' => 'array',
        'other_lettering' => 'array',
        'carving_v_sunk' => 'array',
        'carving_u_sunk' => 'array',
        'carving_shallow_sunk' => 'array',
        'carving_skin_sunk' => 'array',
        'carving_polish_raised_not_cleaned' => 'array',
        'carving_polish_raised_cleaned' => 'array',
        'carving_frosted_inlaid' => 'array',
        'carving_polish_inlaid' => 'array',
        'carving_frosted_edge' => 'array',
        'carving_polish_edge' => 'array',
        'carving_shadow_bar' => 'array',
        ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }

    public function products(){
        return $this->hasMany(MemorialProductionProduct::class);
    }
}
