@extends('layouts.app')

@section('titulo', $filme->nome)

@section('conteudo')

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="row">

            {{-- Poster --}}
            <div class="col-md-4 text-center">

                @php
                    $poster = $filme->imagens->firstWhere('pivot.poster', true);
                @endphp

                @if($poster)

                    <img
                        src="{{ asset('storage/'.$poster->caminho) }}"
                        class="img-fluid rounded shadow"
                        style="max-height:600px; object-fit:cover;"
                        alt="Poster">

                @else

                    <img
                        src="{{ asset('images/sem-poster.jpg') }}"
                        class="img-fluid rounded shadow"
                        style="max-height:600px;"
                        alt="Sem poster">

                @endif

            </div>

            {{-- Informações --}}
            <div class="col-md-8">

                <div class="mb-3">
                    <label class="form-label fw-bold">Nome</label>
                    <input
                        type="text"
                        class="form-control"
                        value="{{ $filme->nome }}"
                        readonly>
                </div>

                <div class="row">

                    <div class="col-md-6">

                        <label class="form-label fw-bold">Duração</label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $filme->duracao }}"
                            readonly>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-bold">Classificação</label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $filme->classificacao }}"
                            readonly>

                    </div>

                </div>

                <div class="mt-3">

                    <label class="form-label fw-bold">
                        Data de lançamento
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $filme->data_lancamento }}"
                        readonly>

                </div>

                <div class="mt-3">

                    <label class="form-label fw-bold">
                        Gêneros
                    </label>

                    <div>

                        @foreach($filme->generos as $genero)

                            <span class="badge bg-primary me-1">
                                {{ $genero->nome }}
                            </span>

                        @endforeach

                    </div>

                </div>

                <div class="mt-3">

                    <label class="form-label fw-bold">
                        Diretores
                    </label>

                    @foreach($filme->diretores as $diretor)

                        <input
                            type="text"
                            class="form-control mb-2"
                            value="{{ $diretor->pessoa->nome }}"
                            readonly>

                    @endforeach

                </div>

                <div class="mt-3">

                    <label class="form-label fw-bold">
                        Produtores
                    </label>

                    @foreach($filme->produtores as $produtor)

                        <input
                            type="text"
                            class="form-control mb-2"
                            value="{{ $produtor->pessoa->nome }}"
                            readonly>

                    @endforeach

                </div>

                <div class="mt-3">

                    <label class="form-label fw-bold">
                        Escritores
                    </label>

                    @foreach($filme->escritores as $escritor)

                        <input
                            type="text"
                            class="form-control mb-2"
                            value="{{ $escritor->pessoa->nome }}"
                            readonly>

                    @endforeach

                </div>

            </div>

        </div>

        {{-- Sinopse --}}
        <div class="mt-4">

            <label class="form-label fw-bold">
                Sinopse
            </label>

            <textarea
                class="form-control"
                rows="6"
                readonly>{{ $filme->sinopse }}</textarea>

        </div>

        {{-- Elenco --}}
        <div class="mt-5">

            <h4 class="mb-3">
                Elenco
            </h4>

            <div class="row">

                @foreach($filme->atores as $ator)

                    <div class="col-md-3 mb-4">

                        <div class="card h-100 shadow-sm">

                            @php
                                $foto = $ator->pessoa->imagens->first() ?? null;
                            @endphp

                            @if($foto)

                                <img
                                    src="{{ asset('storage/'.$foto->caminho) }}"
                                    class="card-img-top"
                                    style="height:250px;object-fit:cover;">

                            @else

                                <img
                                    src="{{ asset('images/user.png') }}"
                                    class="card-img-top"
                                    style="height:250px;object-fit:cover;">

                            @endif

                            <div class="card-body text-center">

                                <h6>
                                    {{ $ator->pessoa->nome }}
                                </h6>

                                <small class="text-muted">

                                    {{ $ator->pivot->papel }}

                                </small>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

        {{-- Galeria --}}
        @if($filme->imagens->count())

            <div class="mt-5">

                <h4 class="mb-3">
                    Galeria de imagens
                </h4>

                <div class="row">

                    @foreach($filme->imagens as $img)

                        <div class="col-md-3 mb-3">

                            <img
                                src="{{ asset('storage/'.$img->caminho) }}"
                                class="img-fluid rounded shadow border {{ $img->pivot->poster ? 'border-danger border-3' : '' }}">

                        </div>

                    @endforeach

                </div>

            </div>

        @endif

        <div class="mt-4">

            <a href="{{ route('filmes.index') }}" class="btn btn-secondary">
                Voltar
            </a>

            <a href="{{ route('filmes.edit',$filme->id) }}" class="btn btn-warning">
                Editar
            </a>

        </div>

    </div>

</div>

@endsection
```
