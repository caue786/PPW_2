@extends('layouts.app')

@section('titulo', $pessoa->nome)

@section('conteudo')

<div class="container mt-5">

    @php
        $poster = $pessoa->imagens->firstWhere('pivot.poster', true);
    @endphp

    <div class="card shadow p-4">

        <div class="row">

            <div class="col-md-3">

                @if($poster)

                    <img src="{{ asset('storage/'.$poster->caminho) }}"
                        class="img-fluid rounded shadow w-100">

                @else

                    <img src="{{ asset('images/sem-foto.jpg') }}"
                        class="img-fluid rounded shadow w-100">

                @endif

            </div>

            <div class="col-md-9">

                <h1>{{ $pessoa->nome }}</h1>

                <hr>

                <div class="row">

                    <div class="col-md-6">

                        <label class="fw-bold">CPF</label>

                        <input class="form-control" readonly
                            value="{{ $pessoa->cpf }}">

                    </div>

                    <div class="col-md-6">

                        <label class="fw-bold">Data nascimento</label>

                        <input class="form-control" readonly
                            value="{{ $pessoa->data_nascimento }}">

                    </div>

                </div>

                <div class="row mt-3">

                    <div class="col-md-6">

                        <label class="fw-bold">Gênero</label>

                        <input class="form-control" readonly
                            value="{{ $pessoa->genero }}">

                    </div>

                    <div class="col-md-6">

                        <label class="fw-bold">Nacionalidade</label>

                        <input class="form-control" readonly
                            value="{{ $pessoa->nacionalidade }}">

                    </div>

                </div>

                <div class="mt-3">

                    <label class="fw-bold">Biografia</label>

                    <textarea readonly class="form-control"
                        rows="6">{{ $pessoa->biografia }}</textarea>

                </div>

                <div class="mt-3">

                    @if($pessoa->ator)
                        <span class="badge bg-primary">Ator</span>
                    @endif

                    @if($pessoa->diretor)
                        <span class="badge bg-success">Diretor</span>
                    @endif

                    @if($pessoa->escritor)
                        <span class="badge bg-warning text-dark">Escritor</span>
                    @endif

                    @if($pessoa->produtor)
                        <span class="badge bg-danger">Produtor</span>
                    @endif

                </div>

            </div>

        </div>

    </div>

    {{-- Atuou --}}

    @if($pessoa->ator && $pessoa->ator->filmes->count())

    <div class="card shadow mt-4">

        <div class="card-header">

            <h3>Atuou em</h3>

        </div>

        <div class="card-body">

            @foreach($pessoa->ator->filmes as $filme)

                @php
                    $posterFilme = $filme->imagens->firstWhere('pivot.poster',true);
                @endphp

                <div class="d-flex align-items-center border-bottom py-3">

                    @if($posterFilme)

                        <img src="{{ asset('storage/'.$posterFilme->caminho) }}"
                            width="80"
                            class="rounded me-3">

                    @endif

                    <div>

                        <h5>{{ $filme->nome }}</h5>

                        <small class="text-muted">

                            {{ $filme->pivot->papel }}

                        </small>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

    @endif

    {{-- Dirigiu --}}

    @if($pessoa->diretor && $pessoa->diretor->filmes->count())

    <div class="card shadow mt-4">

        <div class="card-header">

            <h3>Dirigiu</h3>

        </div>

        <div class="card-body">

            @foreach($pessoa->diretor->filmes as $filme)

                @php
                    $posterFilme = $filme->imagens->firstWhere('pivot.poster',true);
                @endphp

                <div class="d-flex align-items-center border-bottom py-3">

                    @if($posterFilme)

                        <img src="{{ asset('storage/'.$posterFilme->caminho) }}"
                            width="80"
                            class="rounded me-3">

                    @endif

                    <h5>{{ $filme->nome }}</h5>

                </div>

            @endforeach

        </div>

    </div>

    @endif

    {{-- Escreveu --}}

    @if($pessoa->escritor && $pessoa->escritor->filmes->count())

    <div class="card shadow mt-4">

        <div class="card-header">

            <h3>Escreveu</h3>

        </div>

        <div class="card-body">

            @foreach($pessoa->escritor->filmes as $filme)

                @php
                    $posterFilme = $filme->imagens->firstWhere('pivot.poster',true);
                @endphp

                <div class="d-flex align-items-center border-bottom py-3">

                    @if($posterFilme)

                        <img src="{{ asset('storage/'.$posterFilme->caminho) }}"
                            width="80"
                            class="rounded me-3">

                    @endif

                    <h5>{{ $filme->nome }}</h5>

                </div>

            @endforeach

        </div>

    </div>

    @endif

    {{-- Produziu --}}

    @if($pessoa->produtor && $pessoa->produtor->filmes->count())

    <div class="card shadow mt-4">

        <div class="card-header">

            <h3>Produziu</h3>

        </div>

        <div class="card-body">

            @foreach($pessoa->produtor->filmes as $filme)

                @php
                    $posterFilme = $filme->imagens->firstWhere('pivot.poster',true);
                @endphp

                <div class="d-flex align-items-center border-bottom py-3">

                    @if($posterFilme)

                        <img src="{{ asset('storage/'.$posterFilme->caminho) }}"
                            width="80"
                            class="rounded me-3">

                    @endif

                    <h5>{{ $filme->nome }}</h5>

                </div>

            @endforeach

        </div>

    </div>

    @endif

    {{-- Galeria --}}

    @if($pessoa->imagens->count())

    <div class="card shadow mt-4 mb-5">

        <div class="card-header">

            <h3>Galeria de imagens</h3>

        </div>

        <div class="card-body">

            <div class="d-flex flex-wrap gap-3">

                @foreach($pessoa->imagens as $imagem)

                    <img src="{{ asset('storage/'.$imagem->caminho) }}"
                        width="180"
                        class="rounded shadow">

                @endforeach

            </div>

        </div>

    </div>

    @endif

</div>

@endsection