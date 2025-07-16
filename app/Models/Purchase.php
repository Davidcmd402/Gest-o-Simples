<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'supplier_id',
        'quantity',
        'purchase_price',
    ];

    // Produto relacionado à compra
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Fornecedor da compra (opcional)
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
