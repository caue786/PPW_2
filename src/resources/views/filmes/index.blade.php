@extends('layouts.app')

@section('titulo', 'Filmes')

@section('conteudo')

<div class="container mt-5">

    <h1 class="mb-4">
        Lista de Filmes
    </h1>

    @foreach ($filmes as $filme)

        <div class="card mb-3 p-3">

            <h3>
                {{ $filme->nome }}
            </h3>

            @if ($filme->poster_url)

                <img
                    src="{{ asset('storage/' . $filme->poster_url) }}"
                    width="200"
                    class="rounded"
                >

            @endif

        </div>

    @endforeach

</div>

@endsection