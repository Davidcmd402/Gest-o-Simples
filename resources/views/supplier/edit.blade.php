<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <h1 class="mb-4 text-center">Editar Fornecedor</h1>

            <form id="editFormSupplier" method="POST" action="{{ route('supplier.update', $supplier->id) }}">
                @csrf
                @method('PUT')

                @include('supplier.partials.form-fields', ['supplier' => $supplier])

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>
