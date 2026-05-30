@extends('layouts.app')

@section('titulo', $filme->nome)

@section('conteudo')

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="row">

            <div class="col-md-4">

                @php
                    $poster = $filme->imagens->firstWhere('pivot.poster', true);
                @endphp

                @if ($poster)

                    <img
                        src="{{ asset('storage/' . $poster->caminho) }}"
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

        {{-- GALERIA DE IMAGENS --}}
        @if ($filme->imagens->count())
            <div class="mt-4">
                <h5>Imagens</h5>

                <div class="d-flex gap-2 flex-wrap">

                    @foreach ($filme->imagens as $img)
                        <img
                            src="{{ asset('storage/' . $img->caminho) }}"
                            width="120"
                            class="rounded border {{ $img->pivot->poster ? 'border-danger' : '' }}">
                    @endforeach

                </div>
            </div>
        @endif

    </div>

</div>

@endsection