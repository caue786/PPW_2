@extends('layouts.app')

@section('titulo', 'Painel Administrativo')

@section('conteudo')

<div class="container mt-5">

    <h1>Painel Administrativo</h1>

    <hr>

    <div class="list-group">

        <a href="{{ route('filmes.index') }}" class="list-group-item list-group-item-action">
             Gerenciar Filmes
        </a>

        <a href="{{ route('pessoas.index') }}" class="list-group-item list-group-item-action">
             Gerenciar Pessoas
        </a>

        <a href="{{ route('generos.index') }}" class="list-group-item list-group-item-action">
             Gerenciar Gêneros
        </a>

        <a href="{{ route('estudios.index') }}" class="list-group-item list-group-item-action">
             Gerenciar Estúdios
        </a>

    </div>

</div>

@endsection