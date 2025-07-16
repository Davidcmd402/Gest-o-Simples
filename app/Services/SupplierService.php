<?php


namespace App\Services;

use App\Models\Supplier;
class supplierService {



    public function getAllSuppliers() {
        return Supplier::all();
    }

    public function findById($id){
        return Supplier::findOrFail($id);
    }

}
