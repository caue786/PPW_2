@extends('layouts.app')

@section('titulo', 'Produtos Caros')

@section('conteudo')
    <h1 class="mb-2 fw-bold">Produtos acima de R$ 500,00</h1>
    <p class="text-muted">Total de produtos encontrados: {{ $totalProdutos }}</p>

    <div class="row g-3">
        @forelse ($produtos as $produto)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $produto->nome }}</h5>

                        <p class="card-text text-muted mb-3">
                            R$ {{ number_format($produto->preco, 2, ',', '.') }}
                        </p>
                    </div>

                    <div class="card-footer">
                        <a href="/produtos/{{ $produto->id }}" class="btn btn-primary btn-sm">
                            Ver detalhes
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">
                    Nenhum produto acima de R$ 500,00 foi encontrado.
                </div>
            </div>
        @endforelse
    </div>
@endsection