@extends('layouts.app')

@section('titulo', 'Detalhes do Produto')

@section('conteudo')
    <h1 class="mb-4 fw-bold">Detalhes do Produto</h1>

    @includeWhen(!$produto, 'partials.alerta', [
        'tipo' => 'Erro',
        'mensagem' => 'Produto não encontrado.'
    ])

    @isset($produto)
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title fw-bold mb-3">{{ $produto['nome'] }}</h3>

                        <p class="text-muted mb-3">
                            Preço: R$ {{ number_format($produto['preco'], 2, ',', '.') }}
                        </p>

                        <p class="mb-3">
                            <span class="fw-bold">Categoria:</span> {{ $produto['categoria'] }}
                        </p>

                        @if ($produto['disponivel'])
                            <span class="badge bg-success mb-3">Disponível</span>
                        @else
                            <span class="badge bg-secondary mb-3">Indisponível</span>
                        @endif

                        <div class="mt-4">
                            <a href="/produtos" class="btn btn-secondary">Voltar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset
@endsection