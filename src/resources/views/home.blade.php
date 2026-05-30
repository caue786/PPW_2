@extends('layouts.app')

@section('titulo', 'Home')

@section('conteudo')

    @if(request('busca'))

        <div class="container mt-4">

            <h2 class="mb-4">

                {{
                $filmes->count()
                + $pessoas->count()
                + $estudios->count()
                + $generos->count()
                    }}

                resultado(s) encontrado(s) para
                "{{ request('busca') }}"

            </h2>

            {{-- FILMES --}}
            <h4 class="mb-3">Filmes</h4>

            <div class="row g-3 mb-5">

                @forelse($filmes as $filme)

                    @php
                        $poster = $filme->imagens->firstWhere('pivot.poster', true);
                    @endphp

                    <div class="col-md-3">

                        <div class="card h-100 shadow-sm">

                            @if($poster)

                                <img src="{{ asset('storage/' . $poster->caminho) }}" class="card-img-top"
                                    style="height:300px; object-fit:cover;">

                            @else

                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                                    style="height:300px;">

                                    Sem imagem

                                </div>

                            @endif

                            <div class="card-body text-center">

                                <h5>{{ $filme->nome }}</h5>

                                <a href="{{ route('filmes.show', $filme->id) }}" class="btn btn-info btn-sm">
                                    Ver filme
                                </a>

                            </div>

                        </div>

                    </div>

                @empty

                    <p>Nenhum filme encontrado.</p>

                @endforelse

            </div>

            {{-- PESSOAS --}}
            <h4 class="mb-3">Pessoas</h4>

            <div class="row g-3 mb-5">

                @forelse($pessoas as $pessoa)

                    <div class="col-md-3">

                        <div class="card h-100 shadow-sm">

                            @php
                                $foto = $pessoa->imagens->first();
                            @endphp

                            @if($foto)

                                <img src="{{ asset('storage/' . $foto->caminho) }}" class="card-img-top"
                                    style="height:300px; object-fit:cover;">

                            @else

                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                                    style="height:300px;">

                                    Sem foto

                                </div>

                            @endif

                            <div class="card-body text-center">

                                <h5>{{ $pessoa->nome }}</h5>

                                <div class="mb-2">

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

                                <a href="{{ route('pessoas.show', $pessoa->id) }}" class="btn btn-info btn-sm">
                                    Ver pessoa
                                </a>

                            </div>

                        </div>

                    </div>

                @empty

                    <p>Nenhuma pessoa encontrada.</p>

                @endforelse

            </div>

            {{-- ESTÚDIOS --}}
            <h4 class="mb-3">Estúdios</h4>

            <div class="row g-3 mb-5">

                @forelse($estudios as $estudio)

                    <div class="col-md-3">

                        <div class="card h-100 shadow-sm">

                            @php
                                $poster = $estudio->imagens->firstWhere('pivot.poster', true);
                            @endphp

                            @if($poster)

                                <img src="{{ asset('storage/' . $poster->caminho) }}" class="card-img-top"
                                    style="height:250px; object-fit:cover;">

                            @endif

                            <div class="card-body text-center">

                                <h5>{{ $estudio->nome }}</h5>

                                <p class="text-muted">
                                    {{ $estudio->local }}
                                </p>

                                <a href="{{ route('estudios.show', $estudio->id) }}" class="btn btn-info btn-sm">
                                    Ver estúdio
                                </a>

                            </div>

                        </div>

                    </div>

                @empty

                    <p>Nenhum estúdio encontrado.</p>

                @endforelse

            </div>

            {{-- GÊNEROS --}}
            <h4 class="mb-3">Gêneros</h4>

            <div class="row g-3">

                @forelse($generos as $genero)

                    <div class="col-md-3">

                        <div class="card h-100 shadow-sm">

                            @if($genero->imagem)

                                <img src="{{ asset('storage/' . $genero->imagem) }}" class="card-img-top"
                                    style="height:200px; object-fit:cover;">

                            @endif

                            <div class="card-body text-center">

                                <h5>{{ $genero->nome }}</h5>

                                <a href="{{ route('generos.show', $genero->id) }}" class="btn btn-info btn-sm">
                                    Ver gênero
                                </a>

                            </div>

                        </div>

                    </div>

                @empty

                    <p>Nenhum gênero encontrado.</p>

                @endforelse

            </div>

        </div>

    @else

        <!-- CARROSSEL -->
        <div id="carousel" class="carousel slide mb-5">

            <div class="carousel-inner">

                <div class="carousel-item active">
                    <div class="bg-secondary text-white d-flex justify-content-center align-items-center rounded"
                        style="height: 350px;">
                        Banner 1
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="bg-secondary text-white d-flex justify-content-center align-items-center rounded"
                        style="height: 350px;">
                        Banner 2
                    </div>
                </div>

            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>

        </div>

        <h4 class="mb-3">Filmes favoritos dos fãs</h4>

        <div class="row mb-5">

            @for ($i = 0; $i < 6; $i++)

                <div class="col-md-2 mb-4">

                    <div class="card shadow-sm filme-card">

                        <div class="bg-secondary" style="height: 200px;"></div>

                        <div class="card-body text-center">
                            <p class="card-text">Filme</p>
                        </div>

                    </div>

                </div>

            @endfor

        </div>

        <h4 class="mb-3">Celebridades mais populares</h4>

        <div class="row mb-5">

            @for ($i = 0; $i < 4; $i++)

                <div class="col-md-3 mb-4">

                    <div class="card text-center shadow-sm p-3">

                        <div class="rounded-circle bg-secondary mx-auto mb-2" style="width: 80px; height: 80px;">
                        </div>

                        <p>Autor</p>

                    </div>

                </div>

            @endfor

        </div>

    @endif

@endsection