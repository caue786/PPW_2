<?php

namespace App\Http\Controllers;

// Models utilizados pelo controller
use App\Models\Pessoa;
use App\Models\Ator;
use App\Models\Diretor;
use App\Models\Escritor;
use App\Models\Produtor;
use Illuminate\Http\Request;
use App\Models\Imagem;
use Illuminate\Support\Facades\DB;

class PessoaController extends Controller
{
    /**
     * Exibe os detalhes públicos de uma pessoa.
     */
    public function showPublic(string $id)
    {
        // Carrega a pessoa juntamente com suas imagens e todos os filmes
        // relacionados aos papéis que ela exerce.
        $pessoa = Pessoa::with([
            'imagens',
            'ator.filmes.imagens',
            'diretor.filmes.imagens',
            'escritor.filmes.imagens',
            'produtor.filmes.imagens'
        ])->findOrFail($id);

        return view('pessoas.show-public', compact('pessoa'));
    }

    /**
     * Lista todas as pessoas cadastradas.
     */
    public function index()
    {
        // Carrega também os relacionamentos para evitar consultas extras.
        $pessoas = Pessoa::with([
            'ator',
            'diretor',
            'escritor',
            'produtor',
            'imagens'
        ])
            ->orderBy('nome') // Ordena alfabeticamente.
            ->paginate(4);    // Paginação de 4 registros.

        return view('pessoas.index', compact('pessoas'));
    }

    /**
     * Exibe o formulário de cadastro.
     */
    public function create()
    {
        return view('pessoas.create');
    }

    /**
     * Salva uma nova pessoa.
     */
    public function store(Request $request)
    {
        // Validação dos dados enviados pelo formulário.
        $dados = $request->validate([
            'cpf' => 'required|unique:pessoas',
            'nome' => 'required',
            'data_nascimento' => 'nullable|date',
            'biografia' => 'nullable',
            'genero' => 'nullable',
            'nacionalidade' => 'nullable',

            // Validação das imagens.
            'imagens' => 'nullable',
            'imagens.*' => 'image|mimes:jpeg,png,webp,jpg|max:2048'
        ]);

        // Inicia uma transação para garantir a integridade dos dados.
        DB::beginTransaction();

        try {

            // Cria a pessoa.
            $pessoa = Pessoa::create([
                'cpf' => $dados['cpf'],
                'nome' => $dados['nome'],
                'data_nascimento' => $dados['data_nascimento'] ?? null,
                'biografia' => $dados['biografia'] ?? null,
                'genero' => $dados['genero'] ?? null,
                'nacionalidade' => $dados['nacionalidade'] ?? null,
            ]);

            // Cria os tipos selecionados pelo usuário.
            if ($request->has('ator')) {
                Ator::create([
                    'pessoa_id' => $pessoa->id
                ]);
            }

            if ($request->has('diretor')) {
                Diretor::create([
                    'pessoa_id' => $pessoa->id
                ]);
            }

            if ($request->has('escritor')) {
                Escritor::create([
                    'pessoa_id' => $pessoa->id
                ]);
            }

            if ($request->has('produtor')) {
                Produtor::create([
                    'pessoa_id' => $pessoa->id
                ]);
            }

            // Verifica se foram enviadas imagens.
            if ($request->hasFile('imagens')) {

                $arquivos = $request->file('imagens');

                // Define qual será o pôster principal.
                $posterIndex = $request->input('poster_index', 0);

                foreach ($arquivos as $i => $arquivo) {

                    // Salva o arquivo no storage.
                    $caminho = $arquivo->store('imagens', 'public');

                    // Cria o registro da imagem.
                    $imagem = Imagem::create([
                        'nome' => basename($caminho),
                        'caminho' => $caminho
                    ]);

                    // Faz o relacionamento pessoa x imagem.
                    $pessoa->imagens()->attach(
                        $imagem->id,
                        [
                            'poster' => ($i == $posterIndex)
                        ]
                    );
                }
            }

            // Confirma todas as alterações.
            DB::commit();

            return redirect()
                ->route('pessoas.index')
                ->with('sucesso', 'Pessoa criada com sucesso!');

        } catch (\Exception $e) {

            // Desfaz todas as alterações caso ocorra erro.
            DB::rollBack();

            dd($e);
        }
    }

    /**
     * Exibe os detalhes da pessoa.
     */
    public function show(string $id)
    {
        $pessoa = Pessoa::with([
            'ator',
            'diretor',
            'escritor',
            'produtor',
            'imagens'
        ])->findOrFail($id);

        return view('pessoas.show', compact('pessoa'));
    }

    /**
     * Exibe o formulário de edição.
     */
    public function edit(string $id)
    {
        $pessoa = Pessoa::with([
            'ator',
            'diretor',
            'escritor',
            'produtor',
            'imagens'
        ])->findOrFail($id);

        return view('pessoas.edit', compact('pessoa'));
    }

    /**
     * Atualiza os dados da pessoa.
     */
    public function update(Request $request, string $id)
    {
        $pessoa = Pessoa::findOrFail($id);

        // Valida os novos dados.
        $dados = $request->validate([
            'cpf' => 'required|unique:pessoas,cpf,' . $pessoa->id,
            'nome' => 'required',
            'data_nascimento' => 'nullable|date',
            'biografia' => 'nullable',
            'genero' => 'nullable',
            'nacionalidade' => 'nullable',
            'imagens' => 'nullable',
            'imagens.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        // Atualiza os dados da pessoa.
        $pessoa->update($dados);

        // Atualiza os papéis da pessoa.
        if ($request->has('ator')) {
            Ator::firstOrCreate(['pessoa_id' => $pessoa->id]);
        } else {
            Ator::where('pessoa_id', $pessoa->id)->delete();
        }

        if ($request->has('diretor')) {
            Diretor::firstOrCreate(['pessoa_id' => $pessoa->id]);
        } else {
            Diretor::where('pessoa_id', $pessoa->id)->delete();
        }

        if ($request->has('escritor')) {
            Escritor::firstOrCreate(['pessoa_id' => $pessoa->id]);
        } else {
            Escritor::where('pessoa_id', $pessoa->id)->delete();
        }

        if ($request->has('produtor')) {
            Produtor::firstOrCreate(['pessoa_id' => $pessoa->id]);
        } else {
            Produtor::where('pessoa_id', $pessoa->id)->delete();
        }

        // Atualiza as imagens.
        if ($request->hasFile('imagens')) {

            // Remove os vínculos antigos.
            $pessoa->imagens()->detach();

            $arquivos = $request->file('imagens');
            $posterIndex = $request->input('poster_index', 0);

            foreach ($arquivos as $i => $arquivo) {

                $caminho = $arquivo->store('imagens', 'public');

                $imagem = Imagem::create([
                    'nome' => basename($caminho),
                    'caminho' => $caminho
                ]);

                // Cria novamente os vínculos.
                $pessoa->imagens()->attach(
                    $imagem->id,
                    [
                        'poster' => ($i == $posterIndex)
                    ]
                );
            }
        }

        return redirect()
            ->route('pessoas.index')
            ->with('sucesso', 'Pessoa atualizada com sucesso!');
    }

    /**
     * Remove uma pessoa do sistema.
     */
    public function destroy(string $id)
    {
        $pessoa = Pessoa::findOrFail($id);

        DB::beginTransaction();

        try {

            // Remove os relacionamentos com imagens.
            $pessoa->imagens()->detach();

            // Remove todos os papéis da pessoa.
            Ator::where('pessoa_id', $pessoa->id)->delete();
            Diretor::where('pessoa_id', $pessoa->id)->delete();
            Escritor::where('pessoa_id', $pessoa->id)->delete();
            Produtor::where('pessoa_id', $pessoa->id)->delete();

            // Exclui a pessoa.
            $pessoa->delete();

            DB::commit();

            return redirect()
                ->route('pessoas.index')
                ->with('sucesso', 'Pessoa excluída com sucesso!');

        } catch (\Exception $e) {

            // Desfaz a operação em caso de erro.
            DB::rollBack();

            return redirect()
                ->route('pessoas.index')
                ->with('erro', $e->getMessage());
        }
    }

    /**
     * Pesquisa pessoas pelo nome para vinculação aos filmes.
     */
    public function buscar(Request $request)
    {
        // Obtém o texto digitado pelo usuário.
        $termo = trim($request->input('q', ''));

        // Recebe o ID do filme atual.
        $filmeId = $request->input('filme_id');

        // Evita consultas com menos de 2 caracteres.
        if (strlen($termo) < 2) {
            return response()->json([]);
        }

        // Pesquisa até 8 pessoas.
        $pessoas = Pessoa::with('imagens')
            ->where('nome', 'ilike', "%{$termo}%")
            ->limit(8)
            ->get(['id', 'nome']);

        // Retorna os dados em formato JSON.
        return response()->json($pessoas->map(function ($p) use ($filmeId) {

            $vinculos = [];

            // Verifica se a pessoa já está vinculada ao filme.
            if ($filmeId) {

                if ($p->ator?->filmes()->where('filme_id', $filmeId)->exists())
                    $vinculos[] = 'ator';

                if ($p->diretor?->filmes()->where('filme_id', $filmeId)->exists())
                    $vinculos[] = 'diretor';
            }

            return [
                'id' => $p->id,
                'nome' => $p->nome,
                'vinculos' => $vinculos
            ];
        }));
    }
}