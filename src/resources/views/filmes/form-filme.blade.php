{{-- NOME --}}
<div class="mb-3">
    <label class="form-label">Nome</label>

    <input type="text" name="nome" value="{{ old('nome', $filme->nome ?? '') }}" class="form-control">
</div>

{{-- DURAÇÃO --}}
<div class="mb-3">
    <label class="form-label">Duração</label>

    <input type="text" name="duracao" value="{{ old('duracao', $filme->duracao ?? '') }}" class="form-control"
        placeholder="Ex: 2h 15min">
</div>

{{-- DATA LANÇAMENTO --}}
<div class="mb-3">
    <label class="form-label">Data de lançamento</label>

    <input type="date" name="data_lancamento" value="{{ old('data_lancamento', $filme->data_lancamento ?? '') }}"
        class="form-control">
</div>

{{-- CLASSIFICAÇÃO --}}
<div class="mb-3">
    <label class="form-label">Classificação</label>

    <input type="text" name="classificacao" value="{{ old('classificacao', $filme->classificacao ?? '') }}"
        class="form-control" placeholder="Ex: 14 anos">
</div>

{{-- SINOPSE --}}
<div class="mb-3">
    <label class="form-label">Sinopse</label>

    <textarea name="sinopse" class="form-control" rows="5">{{ old('sinopse', $filme->sinopse ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label class="form-label fw-bold">
        Gêneros
    </label>

    <div class="row">

        @foreach($generos as $genero)

            <div class="col-md-4">

                <div class="form-check">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="generos[]"
                        value="{{ $genero->id }}"

                        @if(
                            in_array(
                                $genero->id,
                                old(
                                    'generos',
                                    isset($filme)
                                        ? $filme->generos->pluck('id')->toArray()
                                        : []
                                )
                            )
                        )
                            checked
                        @endif
                    >

                    <label class="form-check-label">
                        {{ $genero->nome }}
                    </label>

                </div>

            </div>

        @endforeach

    </div>

</div>

@if (isset($filme))
<div class="mb-3">
<label class="form-label fw-bold">Pessoas vinculadas</label>
@foreach ([
    'atores' => ['label' => 'Ator', 'temPersonagem' => true],
    'diretores' => ['label' => 'Diretor', 'temPersonagem' => false],
    'produtores'=> ['label' => 'Produtor', 'temPersonagem' => false],
    'escritores'=> ['label' => 'Escritor', 'temPersonagem' => false],
        ] as $relacao => $config)
@foreach ($filme->$relacao as $item)
    <div class="d-flex align-items-center gap-2 mb-2 card-vinculo-existente">
    <span class="badge bg-secondary">{{ $config['label'] }}</span>
    <span>{{ $item->pessoa->nome }}</span>
@if ($config['temPersonagem'])
<input type="text"
    name="atores_existentes[{{ $item->id }}][papel]"
    value="{{ $item->pivot->papel }}"
    class="form-control form-control-sm"
    style="width:180px"
    placeholder="Papel">
@endif
{{-- Marcador para remoção --}}
<input type="checkbox"
name="remover_vinculos[{{ $relacao }}][]"
value="{{ $item->id }}"
class="form-check-input" title="Remover">
<label class="form-check-label text-danger small">Remover</label>
</div>
@endforeach
@endforeach
</div>
@endif

{{-- Seção de vínculos na partial form-filme.blade.php --}}
<div class="mb-4">
    <label class="form-label fw-bold">Pessoas vinculadas</label>
    {{-- Container onde os cards de vínculo são inseridos --}}
    <div id="vinculos-container"></div>
    <button type="button" id="btn-vincular" class="btn btn-outline-secondary btn-sm mt-2">
        + Vincular pessoa
    </button>
</div>
{{-- Template de um card de vínculo (oculto, clonado pelo JS) --}}
<template id="template-vinculo">
    <div class="card mb-2 card-vinculo">
        <div class="card-body p-2">
            {{-- Campo de busca visível + campo oculto com o ID --}}
            <input type="text" class="form-control mb-2 campo-busca" placeholder="Buscar pelo nome da pessoa...">
            <div class="lista-resultados list-group mb-2"></div>
            <input type="hidden" name="" class="campo-pessoa-id">
            <span class="nome-pessoa text-muted small"></span>
            <select name="" class="form-select form-select-sm mb-2 campo-tipo">
                <option value="ator">Ator</option>
                <option value="diretor">Diretor</option>
                <option value="produtor">Produtor</option>
                <option value="escritor">Escritor</option>
            </select>
            <input type="text" name="" class="form-control form-control-sm campo-personagem"
                placeholder="Nome do personagem">
            <button type="button" class="btn btn-sm btn-outline-danger mt-1 btn-remover">
                Remover vínculo
            </button>
        </div>
    </div>
</template>

{{-- IMAGENS --}}
<div class="mb-3">
    <label class="form-label">Imagens</label>

    <input type="file" name="imagens[]" multiple class="form-control">
</div>

{{-- ESCOLHER POSTER --}}
<div class="mb-3">
    <label class="form-label">
        Qual imagem será o poster?
    </label>

    <input type="number" name="poster_index" class="form-control" value="0">
</div>

{{-- IMAGENS ATUAIS --}}
@if(isset($filme) && $filme->imagens->count())

    <div class="mb-3">

        <label class="form-label">
            Imagens atuais
        </label>

        <div class="d-flex flex-wrap gap-3">

            @foreach($filme->imagens as $img)

                <div>

                    <img src="{{ asset('storage/' . $img->caminho) }}" width="120" class="rounded shadow">

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



@push('scripts')
<script>

    // Obtém o ID do filme atual. Se não existir, recebe null.
    const filmeId = {{ $filme->id ?? 'null' }};

    // Container onde serão adicionados os vínculos dinamicamente.
    const container = document.getElementById('vinculos-container');

    // Template HTML utilizado para criar um novo cartão de vínculo.
    const template = document.getElementById('template-vinculo');

    // Captura o token CSRF do formulário para proteger requisições.
    const csrfToken = document.querySelector('input[name="_token"]').value;

    // Controla o índice dos vínculos criados.
    let indice = 0;

    // Evento executado ao clicar no botão "Vincular Pessoa".
    document.getElementById('btn-vincular').addEventListener('click', () => {

        // Clona o template para criar um novo card.
        const card = template.content.cloneNode(true).querySelector('.card-vinculo');

        // Define o nome do campo oculto de pessoa.
        card.querySelector('.campo-pessoa-id').name = `vinculos[${indice}][pessoa_id]`;

        // Define o nome do campo do tipo (ator ou diretor).
        card.querySelector('.campo-tipo').name = `vinculos[${indice}][tipo]`;

        // Define o nome do campo onde será informado o personagem.
        card.querySelector('.campo-personagem').name = `vinculos[${indice}][papel]`;

        // Inicializa todos os eventos do novo card.
        inicializarCard(card);

        // Adiciona o card na tela.
        container.appendChild(card);

        // Incrementa o índice para o próximo vínculo.
        indice++;
    });

    // Responsável por configurar todos os eventos do card criado.
    function inicializarCard(card) {

        // Campo onde o usuário digita o nome da pessoa.
        const campoBusca = card.querySelector('.campo-busca');

        // Lista onde serão exibidos os resultados da pesquisa.
        const listaResultados = card.querySelector('.lista-resultados');

        // Variável utilizada no debounce.
        let timer;

        // Sempre que o usuário digitar...
        campoBusca.addEventListener('input', () => {

            // Cancela pesquisas anteriores.
            clearTimeout(timer);

            // Aguarda 300ms antes de realizar a busca.
            timer = setTimeout(() =>
                buscarPessoas(campoBusca.value, listaResultados, card),
                300
            );
        });

        // Exibe ou esconde o campo "Personagem".
        card.querySelector('.campo-tipo').addEventListener('change', (e) => {

            card.querySelector('.campo-personagem').style.display =
                e.target.value === 'ator'
                    ? 'block'
                    : 'none';

        });

        // Remove o card da tela.
        card.querySelector('.btn-remover').addEventListener('click', () => {

            card.remove();

            // Atualiza a numeração dos campos restantes.
            reindexarVinculos();

        });
    }

    // Faz a busca das pessoas cadastradas.
    function buscarPessoas(termo, lista, card) {

        // Só pesquisa se houver pelo menos dois caracteres.
        if (termo.length < 2) {
            lista.innerHTML = '';
            return;
        }

        // Faz uma requisição para o Laravel buscando pessoas.
        fetch(`/pessoas/buscar?q=${encodeURIComponent(termo)}&filme_id=${filmeId ?? ''}`, {

            headers: {
                'Accept': 'application/json'
            }

        })

        // Converte a resposta em JSON.
        .then(res => res.json())

        // Recebe a lista de pessoas encontrada.
        .then(pessoas => {

            // Limpa resultados antigos.
            lista.innerHTML = '';

            // Caso não encontre ninguém.
            if (pessoas.length === 0) {

                lista.innerHTML =
                    '<span class="list-group-item text-muted">Nenhum resultado</span>';

                return;
            }

            // Percorre todas as pessoas encontradas.
            pessoas.forEach(p => {

                // Cria um botão para cada pessoa.
                const item = document.createElement('button');

                item.type = 'button';

                item.className =
                    'list-group-item list-group-item-action';

                // Verifica se a pessoa já está vinculada ao filme.
                const aviso =
                    p.vinculos.length > 0
                        ? ` <small class="text-warning">(já vinculado como ${p.vinculos.join(', ')})</small>`
                        : '';

                // Exibe nome + aviso.
                item.innerHTML = `${p.nome}${aviso}`;

                // Quando selecionar uma pessoa...
                item.addEventListener('click', () => {

                    // Salva o ID da pessoa.
                    card.querySelector('.campo-pessoa-id').value = p.id;

                    // Limpa a busca.
                    card.querySelector('.campo-busca').value = '';

                    // Mostra o nome selecionado.
                    card.querySelector('.nome-pessoa').textContent =
                        ' ' + p.nome;

                    // Fecha a lista de resultados.
                    lista.innerHTML = '';

                });

                // Adiciona o botão na lista.
                lista.appendChild(item);

            });

        })

        // Caso aconteça algum erro.
        .catch(err => console.error(err));

    }

    // Atualiza a numeração dos vínculos após remover algum.
    function reindexarVinculos() {

        container.querySelectorAll('.card-vinculo').forEach((card, i) => {

            // Atualiza o nome do campo de pessoa.
            card.querySelector('.campo-pessoa-id').name =
                `vinculos[${i}][pessoa_id]`;

            // Atualiza o nome do campo tipo.
            card.querySelector('.campo-tipo').name =
                `vinculos[${i}][tipo]`;

            // Atualiza o nome do campo personagem.
            card.querySelector('.campo-personagem').name =
                `vinculos[${i}][papel]`;

        });

        // Atualiza o índice com a quantidade atual de cartões.
        indice =
            container.querySelectorAll('.card-vinculo').length;

    }

</script>
@endpush