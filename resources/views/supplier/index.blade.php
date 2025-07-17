@extends('layouts.main')

@section('title', 'Fornecedores')

@section('content')
<div class="container">
  <h1>Lista de Fornecedores</h1>

  <a href="{{ route('supplier.create') }}" class="btn btn-primary mb-3" data-bs-toggle="modal"
    data-bs-target="#createSupplier">Novo
    Fornecedor</a>

  @if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-bordered table-responsive">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Email</th>
        <th>Telefone</th>
        <th>Cidade</th>
        <th>Estado</th>
        <th>Status</th>
        <th>Ações</th>
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
        <td>
          <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="modal"
            data-bs-target="#editSupplier">Editar</a>
          <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" class="d-inline"
            onsubmit="return confirm('Tem certeza que deseja excluir?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Excluir</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  @if(isset($supplier))
  <div class="modal fade" id="editSupplier" tabindex="-1" aria-labelledby="editSupplier" aria-hidden="true">
    <div class="modal-dialog">
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
          <button type="button" class="btn btn-primary"
            onclick="document.getElementById('editFormSupplier').submit();">Editar</button>
        </div>
      </div>
    </div>
  </div>
  @endif

  <div class="modal fade" id="createSupplier" tabindex="-1" aria-labelledby="createSupplier" aria-hidden="true">
    <div class="modal-dialog">
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
          <button type="button" class="btn btn-primary"
            onclick="document.getElementById('createSupplierForm').submit();">Criar</button>
        </div>
      </div>
    </div>
  </div>

  {{ $suppliers->links() }}
</div>
@endsection
