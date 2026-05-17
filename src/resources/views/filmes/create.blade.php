@extends('layouts.app')

@section('titulo', 'Cadastrar Filme')

@section('conteudo')

<div class="container mt-5">

    <div class="card shadow p-4">

        <h1 class="mb-4">
            Cadastrar Filme
        </h1>

        <form
            action="{{ route('filmes.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <div class="mb-3">

                <label class="form-label">
                    Nome
                </label>

                <input
                    type="text"
                    name="nome"
                    class="form-control"
                >

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Poster
                </label>

                <input
                    type="file"
                    name="poster"
                    class="form-control"
                >

                @error('poster')

                    <div class="text-danger">
                        {{ $message }}
                    </div>

                @enderror

            </div>

            <button class="btn btn-primary">
                Salvar
            </button>

        </form>

    </div>

</div>

@endsection