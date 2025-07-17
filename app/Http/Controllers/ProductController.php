<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\SupplierService;

class ProductController extends Controller
{

    public function __construct(protected ProductService $productService, protected SupplierService $supplierService)
{
    $this->productService = $productService;
    $this->supplierService = $supplierService;
}
    public function index(Request $request){
        $products = $this->productService->getFilteredProducts($request);
        $suppliers = $this->supplierService->getAllSuppliers();

        return view('product.index', compact('products', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = $this->supplierService->getAllSuppliers();
        return view('products.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->productService->createProduct($request);

        return redirect()->route('product.index')->with('success', 'Produto criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
