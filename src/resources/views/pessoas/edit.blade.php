@extends('layouts.app')

@section('titulo', 'Editar Pessoa')

@section('conteudo')

<div class="container mt-5">

    <h1>Editar Pessoa</h1>
   @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $erro)
                    <div>{{ $erro }}</div>
                @endforeach
            </div>
        @endif
    <form method="POST"
          action="{{ route('pessoas.update', $pessoa->id) }}"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        @include('pessoas.form')

        <button class="btn btn-primary">
            Atualizar
        </button>

    </form>

</div>

@endsection