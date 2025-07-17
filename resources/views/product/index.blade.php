@extends('layouts.main')

@section('title', 'Produtos')

@section('content')
<div class="container mt-5">
  <form method="GET" action="{{ route('product.index') }}" class="mb-4 row g-3 align-items-end">
    <div class="col-md-3">
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

    <div class="col-md-3">
        <input
            type="checkbox"
            name="is_purchase"
            class="form-check-input"
            id="toggleTipoValor"
            {{ request('is_purchase') ? 'checked' : '' }}
        >
        <label class="form-label" id="valueLabel">Valor de Venda</label>

            <input
            type="number"
            name="price_value"
            class="form-control"
            placeholder="R$"
            value="{{ request('price_value') }}"
            >
    </div>


    <div class="col-md-3 d-flex gap-2">
      <button class="btn btn-primary w-100" type="submit">Filtrar</button>
    </div>

    <div class="col-md-3 d-flex gap-2">
      <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#createProduct">
        Novo Produto
      </button>
    </div>
  </form>



  <div class="row">
    @foreach ($products as $product)
    <div class="col-md-4 mb-3">
      <a  class="text-decoration-none text-dark">
        <div class="card h-100">
          {{-- Área da imagem --}}
          <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
            @if($product->image)
            <img src="{{ asset('img/products/' . $product->image) }}" alt="{{ $product->name }}"
              class="img-fluid h-100 w-100 object-fit-cover">
            @endif
          </div>

          {{-- Informações do produto --}}
          <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text fw-bold">Valor de venda: R$ {{ number_format($product->sale_price, 2, ',', '.') }}</p>
            <p class="card-text fw-bold">Valor de compra: R$ {{ number_format($product->purchase_price, 2, ',', '.') }}</p>
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
    @endforeach
  </div>

  <div class="modal fade" id="createProduct" tabindex="-1" aria-labelledby="createProduct" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Criar Novo Produto</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          @include('product.create')
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-primary"
            onclick="document.getElementById('create-product-form').submit();">
            Criar
          </button>
        </div>
      </div>
    </div>
  </div>

  {{ $products->links() }}
</div>
@endsection
