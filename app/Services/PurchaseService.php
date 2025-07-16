<?php


namespace App\Services;
use App\Models\Purchase;


class PurchaseService {


    public function store($data, $product) {
        Purchase::create([
            'product_id' => $product->id,
            'supplier_id' => $data['supplier'],
            'quantity' => $data['quantity'],
            'purchase_price' => $data['purchase_price'] ?? 0
        ]);
    }


}