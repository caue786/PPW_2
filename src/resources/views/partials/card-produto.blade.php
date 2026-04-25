@extends('layouts.app')

@section('conteudo')
    <h1 class="mb-4">Produtos</h1>

    <div class="row g-3">
        @forelse ($produtos as $produto)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">

                    <div class="card-body">
                        <h5 class="card-title">{{ $produto->nome }}</h5>

                        <p class="card-text text-muted">
                            R$ {{ number_format($produto->preco, 2, ',', '.') }}
                        </p>

                        @if ($produto->disponivel)
                            <span class="badge bg-success">Disponível</span>
                        @else
                            <span class="badge bg-secondary">Indisponível</span>
                        @endif
                    </div>

                    <div class="card-footer d-flex gap-2">
                        <form action= '/produtos/{{ $produto->id }}' method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm">
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