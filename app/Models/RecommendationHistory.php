<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecommendationHistory extends Model
{
    protected $fillable = [
        'criteria_undertone',
        'criteria_lip_condition',
        'criteria_finish',
        'criteria_long_lasting',
        'criteria_price_range',
        'result_product_name'
    ];
}
