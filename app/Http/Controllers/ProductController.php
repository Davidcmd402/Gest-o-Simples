<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        return view('product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:100',
            'quantity' => 'required|integer|min:0' ,
            'size' => 'required|in:PP,P,M,G,GG',
            'type' => 'required|string|max:50',
            'brand' => 'required|string|max:100',
            'color' => 'required|string|max:50',
            'sale_price' => 'required|numeric|min:0',
            'supplier' => 'nullable|exists:suppliers,id',
            'purchase_price' => 'nullable|numeric|min:0',
        ];

        $data = $request->validate($rules);

        // Faz o processamento da imagem
        $imageName = null;
        if($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->file('image');
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now')) . '.' . $extension;
            $requestImage->move(public_path('img/products'), $imageName);
        }

        $product = Product::create([
            'name' => $data['name'],
            'quantity' => $data['quantity'],
            'size' => $data['size'],
            'type' => $data['type'],
            'brand' => $data['brand'],
            'color' => $data['color'],
            'sale_price' => $data['sale_price'],
            'image' => $imageName
        ]);

        // Criar a relação com o fornecedor caso ele exista




        // Salvar na tabela de compras


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