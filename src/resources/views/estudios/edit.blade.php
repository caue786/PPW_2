@extends('layouts.app')

@section('titulo', 'Editar Estúdio')

@section('conteudo')

<div class="container mt-5">

    <h1>Editar Estúdio</h1>
@if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $erro)
                    <div>{{ $erro }}</div>
                @endforeach
            </div>
        @endif
    <form
        method="POST"
        action="{{ route('estudios.update', $estudio->id) }}"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        @include('estudios.form')

        <button type="submit" class="btn btn-primary">
            Atualizar
        </button>

    </form>

</div>
@endsection