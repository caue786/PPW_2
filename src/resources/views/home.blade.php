@extends('layouts.app')

@section('titulo', 'Home')

@section('conteudo')

    @if(request('busca'))

        <div class="container mt-4">

            <h2 class="mb-4">

                {{
                $filmes->count()
                + $pessoas->count()

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

                                <a href="{{ route('filmes.public', $filme->id) }}" class="btn btn-primary">
                                    Ver Filme
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

                                <a href="{{ route('pessoas.public', $pessoa->id) }}" class="btn btn-primary">
                                    Ver Pessoa
                                </a>

                            </div>

                        </div>

                    </div>

                @empty

                    <p>Nenhuma pessoa encontrada.</p>

                @endforelse

            </div>



    @else

            <div id="carouselHome" class="carousel slide mb-5" data-bs-ride="carousel">

                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselHome" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#carouselHome" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#carouselHome" data-bs-slide-to="2"></button>
                </div>

                <div class="carousel-inner">

                    <!-- Banner 1 -->
                    <div class="carousel-item active">

                        <img src="{{ asset('Banners/bannerVingadores.jpg') }}" class="d-block w-100 banner-home rounded-4"
                            alt="Os Vingadores">

                        <div class="carousel-caption text-start">

                            <h1>Os Vingadores</h1>

                            <p>
                                Os maiores heróis da Terra precisam unir forças para enfrentar Loki e salvar o planeta.
                            </p>



                        </div>

                    </div>

                    <!-- Banner 2 -->
                    <div class="carousel-item">

                        <img src="{{ asset('Banners/bannerHarry.jpg') }}" class="d-block w-100 banner-home rounded-4"
                            alt="Harry Potter">

                        <div class="carousel-caption text-start">

                            <h1>Harry Potter</h1>

                            <p>
                                O jovem bruxo embarca em uma aventura repleta de magia, amizade e grandes desafios.
                            </p>



                        </div>

                    </div>

                    <!-- Banner 3 -->
                    <div class="carousel-item">

                        <img src="{{ asset('Banners/bannerEstrelas.jpg') }}" class="d-block w-100 banner-home rounded-4"
                            alt="Estrelas Além do Tempo">

                        <div class="carousel-caption text-start">

                            <h1>Estrelas Além do Tempo</h1>

                            <p>
                                A emocionante história das mulheres que ajudaram a NASA a vencer a corrida espacial.
                            </p>



                        </div>

                    </div>

                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselHome" data-bs-slide="prev">

                    <span class="carousel-control-prev-icon"></span>

                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#carouselHome" data-bs-slide="next">

                    <span class="carousel-control-next-icon"></span>

                </button>

            </div>

            <style>
                .banner-home {
                    height: 520px;
                    object-fit: cover;
                    border-radius: 20px;
                }

                .carousel-item {
                    position: relative;
                }

                .carousel-item::before {
                    content: '';
                    position: absolute;
                    inset: 0;
                    background: rgba(0, 0, 0, .45);
                    border-radius: 20px;
                }

                .carousel-caption {
                    left: 8%;
                    right: 45%;
                    bottom: 60px;
                    text-align: left;
                }

                .carousel-caption h1 {
                    font-size: 3rem;
                    font-weight: 700;
                    color: #fff;
                }

                .carousel-caption p {
                    font-size: 1.2rem;
                    color: #fff;
                    margin-bottom: 25px;
                }

                .carousel-caption .btn {
                    padding: 12px 28px;
                    font-size: 1.1rem;
                }
            </style>


            <h3 class="mb-4">Filmes favoritos dos fãs</h3>

            <div class="row mb-5">

                @foreach($filmes as $filme)

                    @php
                        $poster = $filme->imagens->firstWhere('pivot.poster', true);
                    @endphp

                    <div class="col-md-2 mb-3">

                        <div class="card h-100 shadow-sm">

                            @if($poster)

                                <img src="{{ asset('storage/' . $poster->caminho) }}" class="card-img-top"
                                    style="height:260px;object-fit:cover;">

                            @else

                                <div class="bg-secondary text-white d-flex justify-content-center align-items-center"
                                    style="height:260px;">

                                    Sem imagem

                                </div>

                            @endif

                            <div class="card-body text-center">

                                <h6>{{ $filme->nome }}</h6>

                                <a href="/filmes-p/{{ $filme->id }}" class="btn btn-primary btn-sm">

                                    Ver

                                </a>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>
            <div class="d-flex justify-content-center mb-5">
                {{ $filmes->links() }}
            </div>

            <h3 class="mb-4">Celebridades mais populares</h3>

            <div class="row">

                @foreach($pessoas as $pessoa)

                    @php
                        $foto = $pessoa->imagens->firstWhere('pivot.poster', true);
                    @endphp

                    <div class="col-md-3 mb-4">

                        <div class="card text-center shadow-sm h-100 p-3">

                            @if($foto)

                                <img src="{{ asset('storage/' . $foto->caminho) }}" class="rounded-circle mx-auto mb-3"
                                    style="width:130px;height:130px;object-fit:cover;">

                            @else

                                <div class="rounded-circle bg-secondary mx-auto mb-3" style="width:130px;height:130px;"></div>

                            @endif

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

                            <a href="/pessoas-p/{{ $pessoa->id }}" class="btn btn-outline-primary btn-sm">

                                Ver perfil

                            </a>

                        </div>

                    </div>

                @endforeach

            </div>

            <div class="d-flex justify-content-center mb-5">
                {{ $pessoas->links() }}
            </div>

            <h3 class="mb-4">
                Avaliações recentes
            </h3>

            <div id="carouselAvaliacoes" class="carousel slide bg-white rounded shadow-sm p-4" data-bs-ride="carousel">

                <div class="carousel-inner">

                    @foreach($avaliacoes as $avaliacao)

                        @php
                            $poster = $avaliacao->filme
                                ->imagens
                                ->firstWhere('pivot.poster', true);
                        @endphp

                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">

                            <div class="px-5">

                                <div class="card shadow-sm w-100">

                                    <div class="card-body">

                                        <div class="row align-items-center">

                                            <div class="col-md-3 text-center">

                                                @if($poster)
                                                    <img src="{{ asset('storage/' . $poster->caminho) }}" class="img-fluid rounded"
                                                        style="height:180px; object-fit:cover;">
                                                @endif

                                            </div>

                                            <div class="col-md-9">

                                                <h4>{{ $avaliacao->titulo }}</h4>

                                                <p class="text-warning fw-bold mb-2">
                                                    ⭐ {{ $avaliacao->nota }}/10
                                                    <span class="text-secondary fw-normal">
                                                        • {{ $avaliacao->usuario->name }}
                                                    </span>
                                                </p>

                                                <p>
                                                    {{ \Illuminate\Support\Str::limit($avaliacao->descricao, 180) }}
                                                </p>

                                                <small class="text-muted">
                                                    Sobre
                                                    <a href="{{ route('filmes.public', $avaliacao->filme->id) }}">
                                                        {{ $avaliacao->filme->nome }}
                                                    </a>
                                                </small>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselAvaliacoes" data-bs-slide="prev">

                    <span class="carousel-control-prev-icon bg-dark rounded-circle"></span>

                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#carouselAvaliacoes" data-bs-slide="next">

                    <span class="carousel-control-next-icon bg-dark rounded-circle"></span>

                </button>

            </div>

        @endif



@endsection