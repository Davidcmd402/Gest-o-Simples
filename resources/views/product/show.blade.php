@extends('layouts.main')

@section('content')
@if(session('success'))
<div class="alert alert-success mt-2 container">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="alert alert-danger mt-2 container">
    @foreach($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif

<div class="container-fluid my-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <h4 class="mb-0">{{ $product->name }}</h4>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#sellModal">
                    Vender
                </button>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProductModal">
                    Editar
                </button>
                <form method="POST" action="{{ route('product.destroy', $product) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Deseja excluir este produto?')">Excluir</button>
                </form>
            </div>
        </div>

        <div class="card-body">
            <div class="row g-4">
                {{-- Coluna Esquerda --}}
                <div class="col-12 col-md-8">
                    <p><strong>Nome:</strong> {{ $product->name }}</p>
                    <p><strong>Quantidade:</strong> {{ $product->quantity }}</p>
                    <p><strong>Tamanho:</strong> {{ $product->size }}</p>
                    <p><strong>Tipo:</strong> {{ ucfirst($product->type) }}</p>
                    <p><strong>Marca:</strong> {{ $product->brand }}</p>
                    <p><strong>Cor:</strong> {{ $product->color }}</p>
                    <p><strong>Preço de Venda:</strong> R$ {{ number_format($product->sale_price, 2, ',', '.') }}</p>

                    <p><strong>Fornecedores:</strong></p>
                    @if ($product->suppliers->isEmpty())
                    <p class="text-muted">Nenhum fornecedor vinculado.</p>
                    @else
                    <ul>
                        @foreach ($product->suppliers as $supplier)
                        <li>
                            {{ $supplier->name }}
                            @if ($supplier->pivot && isset($supplier->pivot->purchase_price))
                            — Preço de compra: R$ {{ number_format($supplier->pivot->purchase_price, 2, ',', '.') }}
                            @endif
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>

                {{-- Coluna Direita (Imagem) --}}
                <div class="col-12 col-md-4 text-center">
                    @if ($product->image)
                    <img src="{{ asset('img/products/' . $product->image) }}" alt="{{ $product->name }}"
                        class="img-fluid rounded object-fit-cover" style="max-height: 300px;">
                    @else
                    <p class="text-muted">Sem imagem disponível</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DE VENDA --}}
    <div class="modal fade" id="sellModal" tabindex="-1" aria-labelledby="sellModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="sellForm" method="POST" action="{{ route('product.sell', $product) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Vender: {{ $product->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body row gy-4">
                        <div class="col-12 col-md-8">
                            <p>Quantidade disponível: <strong id="availableQuantity">{{ $product->quantity }}</strong></p>
                            <label for="sellQuantity">Quantidade a vender:</label>
                            <input type="number" name="quantity" id="sellQuantity" min="1" class="form-control" required>
                            <div id="sellError" class="text-danger mt-2" style="display:none;"></div>
                        </div>
                        <div class="col-12 col-md-4 text-center">
                            @if ($product->image)
                            <img src="{{ asset('img/products/' . $product->image) }}" alt="{{ $product->name }}"
                                class="img-fluid rounded object-fit-cover" style="max-height: 200px;">
                            @else
                            <p class="text-muted">Sem imagem</p>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between flex-wrap gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Confirmar Venda</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL DE EDIÇÃO --}}
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    @include('product.edit')
                </div>
                <div class="modal-footer d-flex justify-content-between flex-wrap gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary"
                        onclick="document.getElementById('editProductForm').submit();">Editar</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- VALIDAÇÃO DE VENDA --}}
<script>
    document.getElementById('sellForm').addEventListener('submit', function(e) {
        const input = document.getElementById('sellQuantity');
        const available = parseInt(document.getElementById('availableQuantity').innerText);
        const errorDiv = document.getElementById('sellError');

        if (parseInt(input.value) > available) {
            e.preventDefault();
            errorDiv.innerText = 'Você está tentando vender mais do que há em estoque.';
            errorDiv.style.display = 'block';
        } else {
            errorDiv.style.display = 'none';
        }
    });
</script>
@endsection
