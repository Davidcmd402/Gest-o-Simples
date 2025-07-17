<div class="container">
  <h1>Editar Fornecedor</h1>
  <form id="editFormSupplier" method="POST" action="{{ route('supplier.update', $supplier->id) }}">
    @csrf
    @method('PUT')
    @include('supplier.partials.form-fields', ['supplier' => $supplier])
  </form>
</div>
