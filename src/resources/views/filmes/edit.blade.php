@extends('layouts.app')

@section('conteudo')

<div class="container mt-5">

    <h1>Editar Filme</h1>

    {{-- ERROS --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $erro)
                <div>{{ $erro }}</div>
            @endforeach
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('filmes.update', $filme->id) }}"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        {{-- USA A PARTIAL --}}
        @include('filmes.form-filme')

        <button class="btn btn-primary">
            Atualizar
        </button>

    </form>

</div>

@endsection