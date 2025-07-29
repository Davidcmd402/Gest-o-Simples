<div class="container my-4">
  <h2 class="mb-4">Editar Produto</h2>

  @if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form id="editProductForm" action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data"
    method="POST">
    @csrf
    @method('PUT')

    <div class="mb-4">
      <label for="image" class="form-label">Imagem do Produto</label>
      @if($product->image)
      <div class="mb-2">
        <img src="{{ asset('img/products/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail"
          style="max-height: 150px;">
      </div>
      <div class="form-check mb-2">
        <input class="form-check-input" type="checkbox" name="remove_image" value="1" id="removeImage">
        <label class="form-check-label" for="removeImage">Remover imagem</label>
      </div>
      @endif
      <input class="form-control" type="file" name="image" id="image">
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="name" class="form-label">Nome</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}"
          required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="quantity" class="form-label">Quantidade</label>
        <input type="number" name="quantity" id="quantity" class="form-control"
          value="{{ old('quantity', $product->quantity) }}" required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="size" class="form-label">Tamanho</label>
        <select name="size" id="size" class="form-select" required>
          <option value="">Selecione</option>
          @foreach (['PP', 'P', 'M', 'G', 'GG'] as $size)
          <option value="{{ $size }}" @if(old('size', $product->size) == $size) selected @endif>{{ $size }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-6 mb-3">
        <label for="brand" class="form-label">Marca</label>
        <input type="text" name="brand" id="brand" class="form-control" value="{{ old('brand', $product->brand) }}"
          required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="type" class="form-label">Tipo</label>
        <input type="text" name="type" id="type" class="form-control" value="{{ old('type', $product->type) }}"
          required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="color" class="form-label">Cor</label>
        <input type="text" name="color" id="color" class="form-control" value="{{ old('color', $product->color) }}"
          required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="sale_price" class="form-label">Preço de Venda</label>
        <input type="number" name="sale_price" id="sale_price" class="form-control" step="0.01"
          value="{{ old('sale_price', $product->sale_price) }}" required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="purchase_price" class="form-label">Preço de Compra</label>
        <input type="number" name="purchase_price" id="purchase_price" class="form-control" step="0.01"
          value="{{ old('purchase_price', optional(optional($product->suppliers->first())->pivot)->purchase_price) }}">
      </div>

      <div class="col-md-12 mb-3">
        <label for="supplier" class="form-label">Fornecedor</label>
        <select name="supplier" id="supplier" class="form-select">
          <option value="">Selecione um fornecedor</option>
          @foreach ($suppliers as $supplier)
          <option value="{{ $supplier->id }}" @if(old('supplier', optional($product->suppliers->first())->id) ==
            $supplier->id) selected @endif>
            {{ $supplier->name }}
          </option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="text-end mt-4">
      <button type="submit" class="btn btn-primary px-4">Salvar Alterações</button>
    </div>
  </form>
</div>