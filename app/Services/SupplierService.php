<?php


namespace App\Services;

use App\Models\Supplier;
class supplierService {



    public function getAllSuppliers() {
        return Supplier::all();
    }

    public function getSupplierPagination($quantity) {
        $suppliers = Supplier::paginate($quantity);
        return $suppliers;
    }

    public function findById($id){
        return Supplier::findOrFail($id);
    }

    public function createSupplier($request) {

        $validated = $request->validate([

            'name'         => 'required|string|max:100',
            'phone_number' => 'required|string|max:20',
            'email'        => 'required|email|max:100|unique:suppliers,email',
            'street'       => 'required|string|max:100',
            'city'         => 'required|string|max:50',
            'state'        => 'required|string|size:2',
            'zip_code'     => 'required|string|max:10',
            'is_active'    => 'sometimes|boolean',
        ]);

        Supplier::create($validated);
    }

    public function newSupplier() {
        $supplier = new Supplier;
        return $supplier;
    }

    public function updateSupplier($request, $supplier) {

        $validated = $request->validate([
            'name'         => 'required|string|max:100',
            'phone_number' => 'required|string|max:20',
            'email'        => 'required|email|max:100|unique:suppliers,email,' . $supplier->id,
            'street'       => 'required|string|max:100',
            'city'         => 'required|string|max:50',
            'state'        => 'required|string|size:2',
            'zip_code'     => 'required|string|max:10',
            'is_active'    => 'sometimes|boolean',
        ]);

        $supplier->update($validated);
    }

    function delete(Supplier $supplier) {

        $supplier->delete();
    }


}