@extends('layouts.app')

@section('titulo', 'Filmes')

@section('conteudo')
@if(session('sucesso'))

    <div class="alert alert-success">

        {{ session('sucesso') }}

    </div>

@endif
    <div class="container mt-5">

        <div class="card shadow p-4">

            <div class="row">

                <div class="col-md-4">

                    @php
                        $poster = $filme->imagens->firstWhere('pivot.poster', true);
                    @endphp

                    @if ($poster)

                        <img src="{{ asset('storage/' . $poster->caminho) }}" class="img-fluid rounded shadow"
                            alt="Poster do filme">

                    @else

                        <img src="{{ asset('images/sem-poster.jpg') }}" class="img-fluid rounded shadow" alt="Sem poster">

                    @endif

                </div>

                <div class="col-md-8">

                    <h1 class="mb-3">
                        {{ $filme->nome }}
                    </h1>
                    @php
                        $media = number_format($filme->avaliacoes->avg('nota') ?? 0, 1);
                    @endphp

                    <div class="mb-3">
                        <span class="fs-5 text-warning">★ {{ $media }}/5</span>
                    </div>
                    <hr>

                    <h4>Sinopse</h4>

                    <p class="text-justify">

                        {{ $filme->sinopse }}

                    </p>
                    <table class="table table-borderless">

                        <tr>
                            <th width="180">Duração</th>
                            <td>{{ $filme->duracao }}</td>
                        </tr>

                        <tr>
                            <th>Classificação</th>
                            <td>{{ $filme->classificacao }}</td>
                        </tr>

                        <tr>
                            <th>Lançamento</th>
                            <td>{{ \Carbon\Carbon::parse($filme->data_lancamento)->format('d/m/Y') }}</td>
                        </tr>

                        <tr>
                            <th>Gêneros</th>
                            <td>

                                @foreach($filme->generos as $genero)

                                    <span class="badge bg-primary">

                                        {{ $genero->nome }}

                                    </span>

                                @endforeach

                            </td>
                        </tr>

                    </table>

                    <hr>

                    <div class="row mt-4">

                        <div class="col-md-4">

                            <div class="card shadow-sm">

                                <div class="card-header">
                                    Diretores
                                </div>

                                <div class="card-body">

                                    @forelse($filme->diretores as $diretor)

                                        <p class="mb-1">
                                            {{ $diretor->pessoa->nome }}
                                        </p>

                                    @empty

                                        <p class="text-muted">
                                            Nenhum diretor.
                                        </p>

                                    @endforelse

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="card shadow-sm">

                                <div class="card-header">
                                    Roteiristas
                                </div>

                                <div class="card-body">

                                    @forelse($filme->escritores as $escritor)

                                        <p class="mb-1">
                                            {{ $escritor->pessoa->nome }}
                                        </p>

                                    @empty

                                        <p class="text-muted">
                                            Nenhum roteirista.
                                        </p>

                                    @endforelse

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="card shadow-sm">

                                <div class="card-header">
                                    Produtores
                                </div>

                                <div class="card-body">

                                    @forelse($filme->produtores as $produtor)

                                        <p class="mb-1">
                                            {{ $produtor->pessoa->nome }}
                                        </p>

                                    @empty

                                        <p class="text-muted">
                                            Nenhum produtor.
                                        </p>

                                    @endforelse

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- GALERIA DE IMAGENS --}}
            @if ($filme->imagens->count())
                <div class="mt-4">
                    <h5>Imagens</h5>

                    <div class="row mt-4">

                        @foreach($filme->imagens as $img)

                            <div class="col-md-3 mb-3">

                                <img src="{{ asset('storage/' . $img->caminho) }}" class="img-fluid rounded shadow-sm">

                            </div>

                        @endforeach

                    </div>
                </div>
            @endif





        </div>
        <hr>
        <h3 class="mt-5 mb-4">Elenco</h3>

        <div class="row">

            @foreach($filme->atores as $ator)

                <div class="col-md-3 mb-4">

                    <div class="card shadow-sm h-100">

                        @php
                            $foto = $ator->pessoa->imagens->firstWhere('pivot.poster', true);
                        @endphp

                        @if($foto)

                            <img src="{{ asset('storage/' . $foto->caminho) }}" class="card-img-top"
                                style="height:320px;object-fit:cover;">

                        @endif

                        <div class="card-body text-center">

                            <h5>

                                {{ $ator->pessoa->nome }}

                            </h5>

                            <p class="text-muted">

                                {{ $ator->pivot->papel }}

                            </p>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>
    </div>

    @auth

        <div class="card shadow-sm mt-5 mb-4">

            <div class="card-header">

                <h4 class="mb-0">
                    Deixe sua avaliação
                </h4>

            </div>

            <div class="card-body">

                <form action="{{ route('avaliacoes.store') }}" method="POST">

                    @csrf

                    <input type="hidden" name="filme_id" value="{{ $filme->id }}">

                    <div class="mb-3">

                        <label class="form-label">

                            Nota

                        </label>

                        <select name="nota" class="form-select" required>

                            <option value="">Selecione uma nota</option>

                            <option value="1">⭐ 1 - Péssimo</option>

                            <option value="2">⭐⭐ 2 - Ruim</option>

                            <option value="3">⭐⭐⭐ 3 - Bom</option>

                            <option value="4">⭐⭐⭐⭐ 4 - Muito bom</option>

                            <option value="5">⭐⭐⭐⭐⭐ 5 - Excelente</option>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Comentário

                        </label>

                        <textarea name="descricao" rows="4" class="form-control"
                            placeholder="Conte o que achou do filme..."></textarea>

                    </div>

                    <div class="text-end">

                        <button type="submit" class="btn btn-primary">

                            Enviar avaliação

                        </button>

                    </div>

                </form>

            </div>

        </div>

    @else

        <div class="alert alert-info mt-5">

            Faça <a href="{{ route('login') }}">login</a> para avaliar este filme.

        </div>

    @endauth

    {{-- resources/views/filmes/show.blade.php --}}
    <section class="mt-5" id="secao-avaliacoes">
        <h3>Avaliações</h3>
        {{-- Container onde o JS injeta os cards de avaliação --}}
        <div id="avaliacoes-container">
            <p class="text-muted">Carregando avaliações...</p>
        </div>
        {{-- Navegação AJAX --}}
        <div class="d-flex align-items-center gap-3 mt-3">
            <button id="btn-anterior" class="btn btn-outline-secondary" disabled>
                ← Anterior
            </button>
            <span id="info-pagina" class="text-muted"></span>
            <button id="btn-proxima" class="btn btn-outline-secondary">
                Próxima →
            </button>
        </div>
    </section>
    {{-- Script inline com o ID do filme para o JS usar --}}
    {{-- O @push('scripts') com o fetch fica abaixo ou num arquivo separado --}}

@endsection
@push('scripts')
    <script>
        const filmeId = {{ $filme->id }};
        let paginaAtual = 1;
        function carregarAvaliacoes(pagina) {
            fetch(`/filmes/${filmeId}/avaliacoes?page=${pagina}`, {
                headers: { 'Accept': 'application/json' }
            })
                .then(res => {
                    if (!res.ok) throw new Error('Erro na requisição');
                    return res.json();
                })
                .then(dados => {
                    renderizarAvaliacoes(dados.data);
                    atualizarNavegacao(dados);
                    paginaAtual = dados.current_page;
                })
                .catch(erro => {
                    document.getElementById('avaliacoes-container').innerHTML =
                        '<p class="text-danger">Erro ao carregar avaliações.</p>';
                });
        }
        // Carrega a primeira página ao abrir a página
        carregarAvaliacoes(1);
        function renderizarAvaliacoes(avaliacoes) {

            const container = document.getElementById('avaliacoes-container');

            container.innerHTML = avaliacoes.map(av => `

                                                <div class="card shadow-sm mb-3">

                                                    <div class="card-body">

                                                        <div class="d-flex justify-content-between align-items-center">

                                                            <strong>${av.usuario.name}</strong>

                                                            <span class="badge bg-warning text-dark">

                                                                ★ ${av.nota}/5

                                                            </span>

                                                        </div>

                                                        <p class="mt-3 mb-0">

                                                            ${av.descricao ?? 'Sem descrição.'}

                                                        </p>

                                                    </div>

                                                </div>

                                            `).join('');
        }

        function atualizarNavegacao(dados) {
            document.getElementById('btn-anterior').disabled = !dados.prev_page_url;
            document.getElementById('btn-proxima').disabled = !dados.next_page_url;
            document.getElementById('info-pagina').textContent =
                `Página ${dados.current_page} de ${dados.last_page}`;
        }
        document.getElementById('btn-anterior')
            .addEventListener('click', () => carregarAvaliacoes(paginaAtual - 1));
        document.getElementById('btn-proxima')
            .addEventListener('click', () => carregarAvaliacoes(paginaAtual + 1));
    </script>
@endpush