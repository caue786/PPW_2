@extends('layouts.app')

@section('titulo', 'Gêneros')

@section('conteudo')

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>Gêneros</h1>

        <a href="{{ route('generos.create') }}" class="btn btn-primary">
            Novo Gênero
        </a>

    </div>

    

    <div class="row g-4">

        @forelse($generos as $genero)

            <div class="col-md-3">

                <div class="card h-100 shadow-sm">

                    @if($genero->imagem)

                        <img
                            src="{{ asset('storage/' . $genero->imagem) }}"
                            class="card-img-top"
                            style="height:220px; object-fit:cover;">

                    @else

                        <div
                            class="bg-dark text-white d-flex align-items-center justify-content-center"
                            style="height:220px;">

                            <h3 class="text-center px-2">
                                {{ $genero->nome }}
                            </h3>

                        </div>

                    @endif

                    <div class="card-body text-center">

                        <h5 class="card-title">
                            {{ $genero->nome }}
                        </h5>

                        <p class="text-muted">
                            {{ $genero->filmes_count }} filme(s)
                        </p>

                        <div class="d-flex justify-content-center gap-2">

                            <a href="{{ route('generos.show', $genero->id) }}"
                               class="btn btn-info btn-sm">
                                Ver
                            </a>

                            <a href="{{ route('generos.edit', $genero->id) }}"
                               class="btn btn-warning btn-sm">
                                Editar
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="alert alert-info">
                    Nenhum gênero encontrado.
                </div>

            </div>

        @endforelse

    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $generos->links() }}
    </div>

</div>

@endsection