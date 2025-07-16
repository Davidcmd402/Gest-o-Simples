<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
       protected $fillable = [
        'name',
        'size',
        'type',
        'color',
        'brand',
        'quantity',
        'sale_price',
        'image'
    ];

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'product_supplier')
                    ->withPivot('purchase_price')
                    ->withTimestamps();
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}