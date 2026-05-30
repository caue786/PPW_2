@extends('layouts.app')

@section('titulo', 'Novo Gênero')

@section('conteudo')

    <div class="container mt-5">

        <h1>Novo Gênero</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $erro)
                    <div>{{ $erro }}</div>
                @endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('generos.store') }}" enctype="multipart/form-data">

           

            @csrf

            @include('generos.form')

            <button class="btn btn-primary">
                Salvar
            </button>

        </form>



    </div>

@endsection