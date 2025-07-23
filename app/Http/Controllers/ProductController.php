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
    public function index(Request $request)
    {
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
        return view('product.create', compact('suppliers'));
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
        $suppliers = $this->supplierService->getAllSuppliers();
        $product->load('suppliers');
        return view('product.show', compact('product', 'suppliers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $data = $this->productService->productEdit($product);
        $product = $data['product'];
        $suppliers = $data['suppliers'];
        return view('product.edit', compact('product', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->productService->productUpdate($request, $product);

        return redirect()->route('product.index')->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->productService->destroy($product);
        return redirect()->route('product.index')->with('success', 'Produto excluído com sucesso!');
    }

    public function sell(Request $request, Product $product)
    {
        $product = $this->productService->productSell($request, $product);

        return redirect()->route('product.show', $product)->with('success', 'Venda realizada com sucesso!');
    }
}