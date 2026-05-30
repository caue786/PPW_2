@extends('layouts.app')

@section('titulo', 'Celebridades ')

@section('conteudo')

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>Celebridade</h1>

        <a href="{{ route('pessoas.create') }}"
            class="btn btn-primary">
            Nova Celebridade
        </a>

    </div>

    <div class="row g-3">

        @forelse ($pessoas as $pessoa)

            @php
                $poster = $pessoa->imagens->firstWhere('pivot.poster', true);
            @endphp

            <div class="col-md-3">

                <div class="card h-100 shadow-sm">

                    @if($poster)

                        <img
                            src="{{ asset('storage/' . $poster->caminho) }}"
                            class="card-img-top"
                            style="height: 300px; object-fit: cover;">

                    @else

                        <div
                            class="bg-secondary d-flex align-items-center justify-content-center"
                            style="height: 300px;">

                            <span class="text-white">
                                Sem imagem
                            </span>

                        </div>

                    @endif

                    <div class="card-body text-center">

                        <h5 class="card-title">
                            {{ $pessoa->nome }}
                        </h5>

                        <div class="mb-2">

                            @if($pessoa->ator)
                                <span class="badge bg-primary">Ator</span>
                            @endif

                            @if($pessoa->diretor)
                                <span class="badge bg-primary">Diretor</span>
                            @endif

                            @if($pessoa->escritor)
                                <span class="badge bg-primary ">Escritor</span>
                            @endif

                            @if($pessoa->produtor)
                                <span class="badge bg-primary">Produtor</span>
                            @endif

                        </div>

                        <div class="d-flex justify-content-center gap-2">

                            <a href="{{ route('pessoas.show', $pessoa->id) }}"
                                class="btn btn-info btn-sm">

                                Ver

                            </a>

                            <a href="{{ route('pessoas.edit', $pessoa->id) }}"
                                class="btn btn-dark btn-sm">

                                Editar

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <p>Nenhuma pessoa cadastrada.</p>

        @endforelse

    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $pessoas->links() }}
    </div>

    <p class="text-muted text-center mt-3">
        Exibindo {{ $pessoas->firstItem() ?? 0 }}–
        {{ $pessoas->lastItem() ?? 0 }}
        de {{ $pessoas->total() }} pessoas
    </p>

</div>

@endsection