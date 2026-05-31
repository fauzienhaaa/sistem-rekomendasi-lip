<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'brand_id',
        'type_id',
        'name',
        'description',
        'image_path',
        'finish',
        'long_lasting',
        'price'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function lipConditions()
    {
        return $this->belongsToMany(LipCondition::class, 'product_lip_condition', 'product_id', 'lip_condition_id');
    }

    public function undertones()
    {
        return $this->belongsToMany(Undertone::class, 'product_undertone', 'product_id', 'undertone_id');
    }
}
