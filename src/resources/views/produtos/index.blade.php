@extends('layouts.app')

@section('titulo', 'Lista de Produtos')

@section('conteudo')
    <h1 class="mb-2 fw-bold">Produtos</h1>
    <p class="text-muted">Total de produtos: {{ $totalProdutos }}</p>

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

                    <div class="card-footer d-flex gap-2">
                        <a href="/produtos/{{ $produto->id }}" class="btn btn-primary btn-sm">
                            Ver detalhes
                        </a>

                        <a href="/produtos/{{ $produto->id }}/edit" class="btn btn-warning btn-sm">
                            Editar
                        </a>

                        <form action="/produtos/{{ $produto->id }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Tem certeza que deseja excluir este produto?')">
                                Excluir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">
                    Nenhum produto encontrado.
                </div>
            </div>
        @endforelse
    </div>
@endsection