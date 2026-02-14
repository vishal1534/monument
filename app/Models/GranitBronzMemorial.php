<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GranitBronzMemorial extends Model
{
    protected $table = 'granit_bronz_memorial';
    protected $guarded = ['id'];
    protected $casts = ['letter_styles' => 'array',
        'order_types' => 'array',
        'oxidation_colors' => 'array',
        'custom_colors' => 'array',
        'scroll_types' => 'array',
        'layouts' => 'array',
        'vases' => 'array'];
}
