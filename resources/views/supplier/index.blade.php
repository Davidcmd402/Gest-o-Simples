@extends('layouts.main')

@section('title', 'Fornecedores')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Lista de Fornecedores</h1>

    {{-- Área de ações --}}
    <div class="row gy-3 align-items-start mb-4">
        {{-- Formulário de busca --}}
        <div class="col-12 col-md-6 col-lg-4">
            <form method="GET" action="{{ route('supplier.index') }}" class="d-flex flex-column flex-md-row gap-2">
                <input
                    type="text"
                    name="key"
                    class="form-control"
                    placeholder="Buscar fornecedor..."
                    value="{{ request('key') }}">
                <button type="submit" class="btn btn-primary w-100 w-md-auto">
                    <i class="bi bi-search"></i> Buscar
                </button>
            </form>
        </div>

        {{-- Botão Novo Fornecedor --}}
        <div class="col-12 col-md-auto">
            <a href="{{ route('supplier.create') }}" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#createSupplier">
                <i class="bi bi-plus-circle"></i> Novo Fornecedor
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>Status</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->email }}</td>
                    <td>{{ $supplier->phone_number }}</td>
                    <td>{{ $supplier->city }}</td>
                    <td>{{ $supplier->state }}</td>
                    <td>{{ $supplier->is_active ? 'Ativo' : 'Inativo' }}</td>
                    <td class="text-center">
                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                            <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editSupplier">Editar</a>
                            <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal de edição --}}
    @if(isset($supplier))
    <div class="modal fade" id="editSupplier" tabindex="-1" aria-labelledby="editSupplier" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Editar Fornecedor</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    @include('supplier.edit')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('editFormSupplier').submit();">Editar</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal de criação --}}
    <div class="modal fade" id="createSupplier" tabindex="-1" aria-labelledby="createSupplier" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Criar Fornecedor</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    @include('supplier.create')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('createSupplierForm').submit();">Criar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $suppliers->links() }}
    </div>
</div>
@endsection
