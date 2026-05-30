@extends('layouts.app')

@section('titulo', $genero->nome)

@section('conteudo')

<div class="container mt-5">

    <div class="card shadow p-4">

        @if($genero->imagem)

            <img
                src="{{ asset('storage/' . $genero->imagem) }}"
                class="img-fluid rounded mb-4"
                style="max-height:400px; object-fit:cover;">

        @endif

        <h1>{{ $genero->nome }}</h1>

        <p class="text-muted">
            {{ $genero->filmes()->count() }} filme(s)
        </p>

    </div>

</div>

@endsection