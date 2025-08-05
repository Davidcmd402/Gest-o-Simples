@extends('layouts.main')

@section('title', 'Produtos')

@section('content')
<div class="container my-5">

  {{-- FILTRO --}}
  <form method="GET" action="{{ route('product.index') }}" class="row gy-3 gx-4 align-items-end">
    <div class="col-12 col-md-4 col-lg-3">
      <label class="form-label">Fornecedor</label>
      <select name="supplier_id" class="form-select">
        <option value="">Todos os Fornecedores</option>
        @foreach ($suppliers as $supplier)
        <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
          {{ $supplier->name }}
        </option>
        @endforeach
      </select>
    </div>

    <div class="col-12 col-md-4 col-lg-3">
      <div class="form-check mb-1">
        <input type="checkbox" name="is_purchase" class="form-check-input" id="toggleTipoValor"
          {{ request('is_purchase') ? 'checked' : '' }}>
        <label class="form-check-label" for="toggleTipoValor" id="valueLabel">Valor de Venda</label>
      </div>
      <input type="number" name="price_value" class="form-control" placeholder="R$"
        value="{{ request('price_value') }}">
    </div>

    <div class="col-6 col-md-4 col-lg-3 d-grid">
      <button class="btn btn-primary" type="submit">Filtrar</button>
    </div>

    <div class="col-6 col-md-4 col-lg-3 d-grid">
      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createProduct">
        Novo Produto
      </button>
    </div>
  </form>

  {{-- CARDS DE PRODUTOS --}}
  <div class="row mt-4">
    @forelse ($products as $product)
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
      <a href="{{ route('product.show', $product) }}" class="text-decoration-none text-dark">
        <div class="card h-100 shadow-sm">
          <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
            style="height: 200px; overflow: hidden;">
            @if($product->image)
            <img src="{{ asset('img/products/' . $product->image) }}" alt="{{ $product->name }}"
              class="img-fluid w-100 h-100 object-fit-cover">
            @endif
          </div>
          <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text fw-bold">Venda: R$ {{ number_format($product->sale_price, 2, ',', '.') }}</p>
            <p class="card-text fw-bold">Compra: R$ {{ number_format($product->purchase_price, 2, ',', '.') }}</p>
            <p class="card-text">{{ $product->type }}</p>
            <p class="card-text">
              Fornecedor:
              @if($product->suppliers->isNotEmpty())
              {{ $product->suppliers->first()->name }}
              @else
              <em>Não vinculado</em>
              @endif
            </p>
          </div>
        </div>
      </a>
    </div>
    @empty
    <div class="col-12">
      <div class="alert alert-info text-center">Nenhum produto encontrado.</div>
    </div>
    @endforelse
  </div>

  {{-- PAGINAÇÃO --}}
  <div class="d-flex justify-content-center mt-4">
    {{ $products->withQueryString()->links('vendor.pagination.bootstrap-5') }}
  </div>

  {{-- MODAL DE CRIAÇÃO --}}

  <x-generic-modal id="createProduct" title="Criar Novo Produto" size="modal-lg">
    @include('product.create')
    <div class="modal-footer d-flex justify-content-between flex-wrap gap-2">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      <button type="button" class="btn btn-primary"
        onclick="document.getElementById('create-product-form').submit();">Salvar</button>
    </div>
  </x-generic-modal>
</div>
@endsection
