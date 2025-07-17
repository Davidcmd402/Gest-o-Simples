<div class="container">
  <h1>Cadastrar Novo Fornecedor</h1>
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <form id="createSupplierForm" method="POST" action="{{ route('supplier.store') }}">
    @csrf
    @php unset($supplier); @endphp
    @include('supplier.partials.form-fields')
  </form>
</div>
