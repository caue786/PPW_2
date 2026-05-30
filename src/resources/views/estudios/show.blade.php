@extends('layouts.app')

@section('titulo', $estudio->nome)

@section('conteudo')

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="row">

            <div class="col-md-4">

                @php
                    $poster = $estudio->imagens->firstWhere('pivot.poster', true);
                @endphp

                @if($poster)

                    <img
                        src="{{ asset('storage/' . $poster->caminho) }}"
                        class="img-fluid rounded shadow">

                @endif

            </div>

            <div class="col-md-8">

                <h1>{{ $estudio->nome }}</h1>

                <p>
                    <strong>Local:</strong>
                    {{ $estudio->local }}
                </p>

            </div>

        </div>

        @if($estudio->imagens->count())

            <div class="mt-4">

                <h4>Imagens</h4>

                <div class="d-flex flex-wrap gap-3">

                    @foreach($estudio->imagens as $img)

                        <div>

                            <img
                                src="{{ asset('storage/' . $img->caminho) }}"
                                width="120"
                                class="rounded shadow">

                            @if($img->pivot->poster)

                                <p class="text-success fw-bold text-center mt-1">
                                    Poster
                                </p>

                            @endif

                        </div>

                    @endforeach

                </div>

            </div>

        @endif

    </div>

</div>

@endsection