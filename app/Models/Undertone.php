<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Undertone extends Model
{
    protected $fillable = ['name'];

    public function products()
    {
        return $this->belongsToMany(Products::class, 'product_undertone', 'undertone_id', 'product_id');
    }
}
