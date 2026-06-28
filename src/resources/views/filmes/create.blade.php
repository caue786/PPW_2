@extends('layouts.app')

@section('titulo', 'Cadastrar Filme')

@section('conteudo')

<div class="container mt-5">

    <h1>Cadastrar Filme</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $erro)
                <div>{{ $erro }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST"
          action="{{ route('filmes.store') }}"
          enctype="multipart/form-data">

        @csrf

        @include('filmes.form-filme')

        <button class="btn btn-success">
            Salvar
        </button>

    </form>

</div>

@endsection