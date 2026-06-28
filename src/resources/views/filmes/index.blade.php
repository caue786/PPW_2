@extends('layouts.app')

@section('titulo', 'Filmes')

@section('conteudo')

    <div class="container mt-5">

        <h1 class="h2 mb-4">Filmes</h1>

        <a href="{{ route('filmes.create') }}" class="btn btn-primary">
            Novo Filme
        </a>


        </form>

        {{-- LISTA DE FILMES --}}
        <div class="row g-3">

            @forelse ($filmes as $filme)

                @php
                    $poster = $filme->imagens->firstWhere('pivot.poster', true);
                @endphp

                <div class="col-md-3">

                    <div class="card h-100 shadow-sm">

                        {{-- POSTER --}}
                        @if ($poster)

                            <img src="{{ asset('storage/' . $poster->caminho) }}" class="card-img-top"
                                style="height: 300px; object-fit: cover;">

                        @else

                            <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 300px;">

                                <span class="text-white">
                                    Sem imagem
                                </span>

                            </div>

                        @endif

                        {{-- TEXTO --}}
                        <div class="card-body text-center">

                            <h5 class="card-title">
                                {{ $filme->nome }}
                            </h5>

                            @if(isset($filme->ano))
                                <p class="text-muted">
                                    {{ $filme->ano }}
                                </p>
                            @endif

                            <div class="d-flex justify-content-center gap-2 mt-3">

                                <a href="{{ route('filmes.show', $filme->id) }}" class="btn btn-info btn-sm">
                                    Ver
                                </a>

                                <a href="{{ route('filmes.edit', $filme->id) }}" class="btn btn-dark btn-sm">
                                    Editar
                                </a>

                                <form action="{{ route('filmes.destroy', $filme->id) }}" method="POST"
                                    onsubmit="return confirm('Deseja realmente excluir este filme?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Excluir
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <p>Nenhum filme encontrado.</p>

            @endforelse

        </div>

        {{-- PAGINAÇÃO --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $filmes->links() }}
        </div>

        {{-- INFO DA PAGINAÇÃO --}}
        <p class="text-muted text-center">

            Exibindo
            {{ $filmes->firstItem() ?? 0 }}
            –
            {{ $filmes->lastItem() ?? 0 }}

            de

            {{ $filmes->total() }}

            filmes

        </p>

    </div>

@endsection