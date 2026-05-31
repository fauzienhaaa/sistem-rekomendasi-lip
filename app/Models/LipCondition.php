<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LipCondition extends Model
{
    protected $fillable = ['name'];

    public function products()
    {
        return $this->belongsToMany(Products::class, 'product_lip_condition', 'lip_condition_id', 'product_id');
    }
}
