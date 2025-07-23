<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Services\SupplierService;

class SupplierController extends Controller
{

    public function __construct(protected SupplierService $supplierService) {
        $this->supplierService = $supplierService;
    }

    public function index(Request $request){
        $suppliers = $this->supplierService->getFilteredSuppliers($request);
        return view('supplier.index', compact('suppliers'));;
    }

    public function create()
    {
        $supplier = $this->supplierService->newSupplier();
        return view('supplier.create', compact('supplier'));
    }

    public function store(Request $request)
    {
        $this->supplierService->createSupplier($request);
        return redirect()->route('supplier.index')->with('success', 'Fornecedor criado com sucesso!');
    }
    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $this->supplierService->updateSupplier($request, $supplier);
        return redirect()->route('supplier.index')->with('success', 'Fornecedor atualizado com sucesso!');
    }

    public function destroy(Supplier $supplier)
    {
        $this->supplierService->delete($supplier);
        return redirect()->route('supplier.index')->with('success', 'Fornecedor removido com sucesso!');
    }
}