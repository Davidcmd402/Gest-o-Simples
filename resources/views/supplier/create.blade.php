<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <h1 class="mb-4 text-center">Cadastrar Novo Fornecedor</h1>

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

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success">Salvar Fornecedor</button>
                </div>
            </form>
        </div>
    </div>
</div>
