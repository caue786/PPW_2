@extends('layouts.app') {{-- Herda o layout principal (navbar + footer) --}}

@section('titulo', 'Home') {{-- Define o título da página --}}

@section('conteudo') {{-- Início do conteúdo específico da Home --}}

    <!--  CARROSSEL -->
    <div id="carousel" class="carousel slide mb-5"> {{-- Componente de carrossel do Bootstrap --}}
        <div class="carousel-inner"> {{-- Área que contém os slides --}}

            <div class="carousel-item active"> {{-- Primeiro slide (ativo) --}}
                <div class="bg-secondary text-white d-flex justify-content-center align-items-center rounded"
                    style="height: 350px;">
                    {{-- Banner simulado com fundo cinza --}}
                    {{-- d-flex + justify + align = centraliza o texto --}}
                    Banner 1
                </div>
            </div>

            <div class="carousel-item"> {{-- Segundo slide (SEM active) --}}
                <div class="bg-secondary text-white d-flex justify-content-center align-items-center rounded"
                    style="height: 350px;">
                    Banner 2
                </div>
            </div>

        </div>

        <!-- Botão anterior -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <!-- Botão próximo -->
        <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!--  FILMES -->
    <h4 class="mb-3">Filmes favoritos dos fãs </h4> {{-- Título da seção --}}

    <div class="row mb-5"> {{-- Linha do grid Bootstrap --}}
        @for ($i = 0; $i < 6; $i++) {{-- Loop para criar 6 cards (simulação) --}}
            <div class="col-md-2 mb-4"> {{-- Cada card ocupa 2 colunas (6 por linha) --}}
                <div class="card shadow-sm filme-card"> {{-- Card Bootstrap --}}
                    
                    <div class="bg-secondary" style="height: 200px;"></div>
                    {{-- Placeholder da imagem do filme --}}

                    <div class="card-body text-center"> {{-- Conteúdo do card --}}
                        <p class="card-text">Filme</p> {{-- Nome do filme (simulado) --}}
                    </div>
                </div>
            </div>
        @endfor
    </div>

    <!--  AUTORES -->
    <h4 class="mb-3">Celebridades mais populares</h4>

    <div class="row mb-5">
        @for ($i = 0; $i < 4; $i++) {{-- Loop criando 4 autores --}}
            <div class="col-md-3 mb-4"> {{-- 4 por linha (12 ÷ 3) --}}
                <div class="card text-center shadow-sm p-3">
                    
                    <div class="rounded-circle bg-secondary mx-auto mb-2"
                        style="width: 80px; height: 80px;">
                    </div>
                    {{-- Círculo simulando foto do autor --}}

                    <p>Autor</p> {{-- Nome do autor --}}
                </div>
            </div>
        @endfor
    </div>

    <!--  AVALIAÇÕES -->
    <h4 class="mb-3">Avaliações</h4>

    <div class="carousel slide mb-5"> {{-- Carrossel para avaliações --}}
        <div class="carousel-inner">

            <div class="carousel-item active"> {{-- Slide ativo --}}
                <div class="d-flex gap-3"> {{-- Flexbox para colocar cards lado a lado --}}

                    @for ($i = 0; $i < 3; $i++) {{-- Loop criando 3 avaliações --}}
                        <div class="card p-3 shadow-sm" style="width: 30%;">
                            
                            <p>Lorem ipsum dolor sit amet...</p>
                            {{-- Texto da avaliação (simulado) --}}

                            <small>1/10</small>
                            {{-- Nota da avaliação --}}
                        </div>
                    @endfor

                </div>
            </div>

        </div>
    </div>

@endsection {{-- Fim do conteúdo da página --}}