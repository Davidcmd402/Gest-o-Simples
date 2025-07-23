<div class="container">
  <h2>Editar Produto</h2>
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

    <div class="mb-3">
      <label for="image" class="form-label">Imagem do Produto</label><br>
      @if($product->image)
      <img src="{{ asset('img/products/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail mb-2"
        style="max-height: 150px;">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remove_image" value="1" id="removeImage">
        <label class="form-check-label" for="removeImage">
          Remover imagem
        </label>
      </div>
      @endif
      <input class="form-control" type="file" name="image" id="image">
    </div>


    <div class="row">
      <div class="col-md-6 mb-3">
        <label>Nome</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
      </div>

      <div class="col-md-6 mb-3">
        <label>Quantidade</label>
        <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $product->quantity) }}"
          required>
      </div>

      <div class="col-md-6 mb-3">
        <label>Tamanho</label>
        <select name="size" class="form-select" required>
          <option value="">Selecione</option>
          @foreach (['PP', 'P', 'M', 'G', 'GG'] as $size)
          <option value="{{ $size }}" @if(old('size', $product->size) == $size) selected @endif>{{ $size }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-6 mb-3">
        <label>Tipo</label>
        <label>Marca</label>
        <input type="text" name="brand" class="form-control" value="{{ old('brand', $product->brand) }}" required>
      </div>

      <div class="col-md-6 mb-3">
        <label>Marca</label>
        <input type="text" name="type" class="form-control" value="{{ old('type', $product->type) }}" required>
      </div>

      <div class="col-md-6 mb-3">
        <label>Cor</label>
        <input type="text" name="color" class="form-control" value="{{ old('color', $product->color) }}" required>
      </div>

      <div class="col-md-6 mb-3">
        <label>Preço de Venda</label>
        <input type="number" name="sale_price" class="form-control" step="0.01"
          value="{{ old('sale_price', $product->sale_price) }}" required>
      </div>

      <div class="col-md-6 mb-3">
        <label>Preço de Compra</label>
        <input type="number" name="purchase_price" class="form-control" step="0.01"
          value="{{ old('purchase_price', optional(optional($product->suppliers->first())->pivot)->purchase_price) }}">

      </div>

      <div class="mb-3">
        <label>Fornecedor</label>
        <select name="supplier" class="form-select">
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

  </form>
</div>
