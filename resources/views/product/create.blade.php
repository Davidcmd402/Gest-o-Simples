<div class="container py-4">
  <h2 class="mb-4">Novo Produto</h2>

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
    <div class="row g-3">
      <!-- Imagem -->
      <div class="col-12 col-md-6">
        <label for="image" class="form-label">Imagem do Produto</label>
        <div class="input-group">
          <input type="file" class="form-control visually-hidden" id="image" name="image" accept="image/*">
          <button type="button" class="btn btn-outline-primary" id="btnSelectImage">Selecionar Imagem</button>
        </div>
        <small id="imageName" class="form-text text-muted mt-1">Nenhum arquivo selecionado</small>
      </div>

      <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
        <img id="imagePreview" src="#" alt="Preview da Imagem"
          style="display: none; border-radius: 8px; box-shadow: 0 0 6px rgba(0,0,0,0.1); max-width: 150px; max-height: 150px; object-fit: cover;">
      </div>

      <!-- Nome -->
      <div class="col-12 col-md-6">
        <label for="name" class="form-label">Nome</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <!-- Quantidade -->
      <div class="col-12 col-md-6">
        <label for="quantity" class="form-label">Quantidade</label>
        <input type="number" name="quantity" class="form-control" required>
      </div>

      <!-- Tamanho -->
      <div class="col-12 col-md-6">
        <label for="size" class="form-label">Tamanho</label>
        <select name="size" class="form-select" required>
          <option value="">Selecione</option>
          @foreach (['PP', 'P', 'M', 'G', 'GG'] as $size)
          <option value="{{ $size }}">{{ $size }}</option>
          @endforeach
        </select>
      </div>

      <!-- Tipo -->
      <div class="col-12 col-md-6">
        <label for="type" class="form-label">Tipo</label>
        <input type="text" name="type" class="form-control" required>
      </div>

      <!-- Marca -->
      <div class="col-12 col-md-6">
        <label for="brand" class="form-label">Marca</label>
        <input type="text" name="brand" class="form-control" required>
      </div>

      <!-- Cor -->
      <div class="col-12 col-md-6">
        <label for="color" class="form-label">Cor</label>
        <input type="text" name="color" class="form-control" required>
      </div>

      <!-- Preço de Venda -->
      <div class="col-12 col-md-6">
        <label for="sale_price" class="form-label">Preço de Venda</label>
        <input type="number" name="sale_price" class="form-control" step="0.01" required>
      </div>

      <!-- Preço de Compra -->
      <div class="col-12 col-md-6">
        <label for="purchase_price" class="form-label">Preço de Compra</label>
        <input type="number" name="purchase_price" class="form-control" step="0.01">
      </div>

      <!-- Fornecedor -->
      <div class="col-12">
        <label for="supplier" class="form-label">Fornecedor</label>
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

<style>
@media (max-width: 576px) {
  #imagePreview {
    max-width: 100% !important;
    height: auto !important;
  }
}
</style>

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
