@extends('layouts.app')

@section('titulo', $filme->nome)

@section('conteudo')

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="row">

            <div class="col-md-4">

                @if ($filme->poster_url)

                    <img
                        src="{{ asset('storage/' . $filme->poster_url) }}"
                        class="img-fluid rounded shadow"
                        alt="Poster do filme">

                @else

                    <img
                        src="{{ asset('images/sem-poster.jpg') }}"
                        class="img-fluid rounded shadow"
                        alt="Sem poster">

                @endif

            </div>

            <div class="col-md-8">

                <h1 class="mb-3">
                    {{ $filme->nome }}
                </h1>

                <p>
                    <strong>Duração:</strong>
                    {{ $filme->duracao }}
                </p>

                <p>
                    <strong>Classificação:</strong>
                    {{ $filme->classificacao }}
                </p>

                <p>
                    <strong>Data lançamento:</strong>
                    {{ $filme->data_lancamento }}
                </p>

                <p>
                    <strong>Sinopse:</strong>
                    {{ $filme->sinopse }}
                </p>

            </div>

        </div>

    </div>

</div>

@endsection