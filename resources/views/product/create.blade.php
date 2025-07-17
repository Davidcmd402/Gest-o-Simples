<div class="container">
  <h2>Novo Produto</h2>
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" id="create-product-form">
    @csrf
    <div class="row">
      <<div class="col-md-6 mb-3">
        <label for="image" class="form-label">Imagem do Produto</label>
        <div class="input-group">
          <input type="file" class="form-control visually-hidden" id="image" name="image" accept="image/*">
          <button type="button" class="btn btn-outline-secondary" id="btnSelectImage">Selecionar Imagem</button>
        </div>
        <small id="imageName" class="form-text text-muted mt-1">Nenhum arquivo selecionado</small>
        <div class="mt-3">
          <img id="imagePreview" src="#" alt="Preview da Imagem"
            style="display: none; border-radius: 8px; box-shadow: 0 0 6px rgba(0,0,0,0.1); max-width: 200px; width: 100%; height: auto;">
        </div>

        <style>
        @media (max-width: 576px) {
          #imagePreview {
            max-width: 150px !important;
            width: 100% !important;
            height: auto !important;
          }
        }
        </style>
    </div>

    <script>
    const fileInput = document.getElementById('image');
    const btnSelect = document.getElementById('btnSelectImage');
    const imageName = document.getElementById('imageName');
    const imagePreview = document.getElementById('imagePreview');

    btnSelect.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', () => {
      if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        imageName.textContent = file.name;

        const reader = new FileReader();
        reader.onload = e => {
          imagePreview.src = e.target.result;
          imagePreview.style.display = 'block';
        };
        reader.readAsDataURL(file);
      } else {
        imageName.textContent = 'Nenhum arquivo selecionado';
        imagePreview.style.display = 'none';
        imagePreview.src = '#';
      }
    });
    </script>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label>Nome</label>
        <input type="text" name="name" class="form-control" required>
      </div>


      <div class="col-md-6 mb-3">
        <label>Quantidade</label>
        <input type="number" name="quantity" class="form-control" required>
      </div>

      <div class="col-md-6 mb-3">
        <label>Tamanho</label>
        <select name="size" class="form-select" required>
          <option value="">Selecione</option>
          @foreach (['PP', 'P', 'M', 'G', 'GG'] as $size)
          <option value="{{ $size }}">{{ $size }}</option>
          @endforeach
        </select>
      </div>

        <div class="col-md-6 mb-3">
            <label>Tipo</label>
            <input type="text" name="type" class="form-control" required>
        </div>

      <div class="col-md-6 mb-3">
        <label>Marca</label>
        <input type="text" name="brand" class="form-control" required>
      </div>

      <div class="col-md-6 mb-3">
        <label>Cor</label>
        <input type="text" name="color" class="form-control" required>
      </div>

      <div class="col-md-6 mb-3">
        <label>Preço de Venda</label>
        <input type="number" name="sale_price" class="form-control" step="0.01" required>
      </div>

      <div class="col-md-6 mb-3">
        <label>Preço de Compra</label>
        <input type="number" name="purchase_price" class="form-control" step="0.01">
      </div>

      <div class="mb-3">
        <label>Fornecedores</label>
        <select name="supplier" class="form-select">
          <option value="">Selecione um fornecedor</option>
          @foreach ($suppliers as $supplier)
          <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
          @endforeach
        </select>
      </div>

    </div>

  </form>
</div>
