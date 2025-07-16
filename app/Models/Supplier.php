<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'street',
        'city',
        'state',
        'zip_code',
        'is_active',
    ];
    public function product()
{
    return $this->belongsToMany(Product::class, 'product_supplier')
                ->withPivot('purchase_price')
                ->withTimestamps();
}
}