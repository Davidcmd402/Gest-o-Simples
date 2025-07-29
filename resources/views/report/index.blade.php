@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h2>Relatório de Vendas</h2>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="start_date" class="form-label">Data inicial</label>
            <input type="date" name="start_date" class="form-control" value="{{ $start }}">
        </div>
        <div class="col-md-4">
            <label for="end_date" class="form-label">Data final</label>
            <input type="date" name="end_date" class="form-control" value="{{ $end }}">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    <div class="row">
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>Total Vendido</h5>
                    <p class="fs-4">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5>Total de Unidades Vendidas</h5>
                    <p class="fs-4">{{ $totalUnitsSold }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5>Total Investido</h5>
                    <p class="fs-4">R$ {{ number_format($totalCost, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h5>Estimativa de Lucro (estoque)</h5>
                    <p class="fs-4">R$ {{ number_format($totalEstimatedRevenue, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    @if ($topSellingProduct)
    <div class="mt-4">
        <h5>Produto mais vendido:</h5>
        <p>
            <strong>{{ $topSellingProduct->name }}</strong>
            ({{ $topSellingQuantity }} unidades)
        </p>
    </div>
    @endif

    <div class="mt-4">
        <h5>Histórico de Vendas:</h5>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $sale->product_name }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>R$ {{ number_format($sale->sale_price, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($sale->quantity * $sale->sale_price, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>



    @endsection
