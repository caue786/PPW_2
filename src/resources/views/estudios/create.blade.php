@extends('layouts.app')
@section('titulo', 'Novo Estúdio')

@section('conteudo')
    <div class="container mt-5">

        <h1>Novo Estúdio</h1>
         
      @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $erro)
                    <div>{{ $erro }}</div>
                @endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('estudios.store') }}" enctype="multipart/form-data">

            @csrf

            @include('estudios.form')

            <button type="submit" class="btn btn-primary">
                Salvar
            </button>

        </form>

    </div>

@endsection