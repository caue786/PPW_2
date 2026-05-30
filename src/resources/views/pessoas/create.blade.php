@extends('layouts.app')

@section('titulo', 'Nova Pessoa')

@section('conteudo')

    <div class="container mt-5">

        <h1>Nova Pessoa</h1>
            @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $erro)
                    <div>{{ $erro }}</div>
                @endforeach
            </div>
        @endif

        @endif
        <form method="POST" action="{{ route('pessoas.store') }}" enctype="multipart/form-data">

            @csrf

            @include('pessoas.form')

            <button class="btn btn-primary">
                Salvar
            </button>

        </form>

    </div>

@endsection