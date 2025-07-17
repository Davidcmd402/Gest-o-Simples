<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products'; // <- Nome real da tabela no banco
       protected $fillable = [
        'name',
        'size',
        'type',
        'color',
        'brand',
        'quantity',
        'sale_price',
        'purchase_price',
        'image'
        // outros campos que queira permitir mass assignment
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