<?php


namespace App\Services;

use App\Models\Product;
use App\Models\Sale;
use App\Services\PurchaseService;
use Illuminate\Http\Request;

class ProductService
{

    public function __construct(protected PurchaseService $purchaseService, protected SupplierService $supplierService)
    {
        $this->purchaseService = $purchaseService;
        $this->supplierService = $supplierService;
    }

    public function getAllProducts()
    {
        return Product::all();
    }

    public function createProduct($request)
    {
        $rules = [
            'name' => 'required|string|max:100',
            'quantity' => 'required|integer|min:0',
            'size' => 'required|in:PP,P,M,G,GG',
            'type' => 'required|string|max:50',
            'brand' => 'required|string|max:100',
            'color' => 'required|string|max:50',
            'sale_price' => 'required|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'supplier' => 'nullable|exists:suppliers,id',
            'purchase_price' => 'nullable|numeric|min:0',
        ];

        $data = $request->validate($rules);

        // Faz o processamento da imagem
        $imageName = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
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
            'purchase_price' => $data['purchase_price'],
            'image' => $imageName
        ]);

        //relaciona com o fornecedor se houver

        if (!empty($data['supplier'])) {
            $product->suppliers()->sync([
                $data['supplier'] => ['purchase_price' => $data['purchase_price'] ?? 0]
            ]);
        }

        //cria e salva a compra realizada

        $this->purchaseService->createPurchase($data, $product);
    }
    public function getFilteredProducts(Request $request)
    {
        $query = Product::with('suppliers');

        if ($request->supplier_id) {
            $supplier = $this->supplierService->findById($request->supplier_id);

            $query->whereHas('suppliers', function ($q) use ($supplier) {
                $q->where('suppliers.id', $supplier->id);
            });
        }

        if ($request->price_value !== null) {
            if ($request->is_purchase) {

                $query->where('purchase_price', '<=', $request->price_value);
            } else {

                $query->where('sale_price', '<=', $request->price_value);
            }
        }

        return $query->paginate(12)->withQueryString();
    }

    public function productSell(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $quantityToSell = $request->quantity;

        if ($quantityToSell > $product->quantity) {
            return back()->withErrors(['quantity' => 'Quantidade solicitada é maior do que a disponível.'])->withInput();
        }

        $product->quantity -= $quantityToSell;
        $product->save();

        Sale::create([
            'product_id' => $product->id,
            'quantity' => $quantityToSell,
            'sale_price' => $product->sale_price,
            'product_name' => $product->name,
        ]);

        return $product;
    }

    public function productUpdate(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'quantity' => 'required|integer|min:0',
            'size' => 'required|in:PP,P,M,G,GG',
            'type' => 'required|string|max:100',
            'brand' => 'required|string|max:100',
            'color' => 'required|string|max:50',
            'sale_price' => 'required|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'supplier' => 'nullable|exists:suppliers,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);

        // Processa a imagem
        if ($request->has('remove_image') && $request->remove_image) {
            if ($product->image && file_exists(public_path('img/products/' . $product->image))) {
                unlink(public_path('img/products/' . $product->image));
            }
            $product->image = null;
        } elseif ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Remove a imagem anterior se existir
            if ($product->image && file_exists(public_path('img/products/' . $product->image))) {
                unlink(public_path('img/products/' . $product->image));
            }

            $requestImage = $request->file('image');
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now')) . '.' . $extension;
            $requestImage->move(public_path('img/products'), $imageName);
            $product->image = $imageName;
        }

        // Atualiza os dados do produto
        $product->update([
            'name' => $data['name'],
            'quantity' => $data['quantity'],
            'size' => $data['size'],
            'type' => $data['type'],
            'brand' => $data['brand'],
            'color' => $data['color'],
            'sale_price' => $data['sale_price'],
            'purchase_price' => $data['purchase_price'],
            'image' => $product->image,
        ]);

        // Atualiza relação com fornecedor, se fornecido
        if (!empty($data['supplier'])) {
            $product->suppliers()->sync([
                $data['supplier'] => ['purchase_price' => $data['purchase_price'] ?? 0]
            ]);
        } else {
            $product->suppliers()->detach();
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();
    }

    public function productEdit(Product $product)
    {
        $suppliers = $this->supplierService->getAllSuppliers();
        $product->load('suppliers');
        return [
            'suppliers' => $suppliers,
            'product' => $product
        ];
    }
}
