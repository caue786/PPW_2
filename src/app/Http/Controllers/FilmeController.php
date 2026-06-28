<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filme;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Genero;
use App\Models\Pessoa;
class FilmeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function indexPublic(string $id)
    {
        $filme = Filme::findOrFail($id);



        return view('filmes.show-public', compact('filme'));
    }
    public function index(Request $request)
    {
        $busca = $request->get('busca');

        $filmes = Filme::with('imagens')
            ->when($busca, function ($query, $busca) {
                return $query->where('nome', 'ilike', "%{$busca}%");
            })
            ->orderBy('nome')
            ->paginate(4)
            ->withQueryString();

        return view('filmes.index', compact('filmes', 'busca'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $generos = Genero::orderBy('nome')->get();

        return view('filmes.create', compact('generos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $dados = $request->validate([

            'nome' => 'required|string',

            'duracao' => 'nullable|string',

            'data_lancamento' => 'nullable|date',

            'classificacao' => 'nullable|string',

            'sinopse' => 'nullable|string',

            'imagens' => 'required',

            'imagens.*' => 'image|mimes:jpeg,png,webp|max:2048',

            'vinculos' => 'nullable|array',
            'vinculos.*.pessoa_id' => 'required_with:vinculos|integer|exists:pessoas,id',
            'vinculos.*.tipo' => 'required_with:vinculos|in:ator,diretor,produtor,escritor',
            'vinculos.*.personagem' => 'nullable|string|max:100',
            'generos' => 'nullable|array',
            'generos.*' => 'exists:generos,id',
        ]);

        DB::beginTransaction();

        try {

            // CRIA FILME
            $filme = Filme::create([

                'nome' => $dados['nome'],

                'duracao' => $dados['duracao'] ?? null,

                'data_lancamento' => $dados['data_lancamento'] ?? null,

                'classificacao' => $dados['classificacao'] ?? null,

                'sinopse' => $dados['sinopse'] ?? null,


            ]);
            $filme->generos()->sync($request->input('generos', []));

            $this->sincronizarVinculos($filme, $request->input('vinculos', []));
            // IMAGENS
            $arquivos = $request->file('imagens');

            $posterIndex = $request->input('poster_index', 0);

            foreach ($arquivos as $i => $arquivo) {

                $caminho = $arquivo->store('imagens', 'public');

                $imagem = \App\Models\Imagem::create([

                    'caminho' => $caminho,

                    'nome' => basename($caminho)

                ]);

                // RELACIONA COM FILME
                $filme->imagens()->attach($imagem->id, [

                    'poster' => ($i == $posterIndex)

                ]);
            }

            DB::commit();

            return redirect('/filmes')
                ->with('sucesso', 'Filme criado com sucesso!');

        } catch (\Exception $e) {

            DB::rollBack();

            dd($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $filme = Filme::with([
        'imagens',
        'generos',
        'atores.pessoa',
        'diretores.pessoa',
        'produtores.pessoa',
        'escritores.pessoa',
        'avaliacoes.usuario'
    ])->findOrFail($id);

    return view('filmes.show', compact('filme'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $filme = Filme::findOrFail($id);

        $generos = Genero::orderBy('nome')->get();

        return view('filmes.edit', compact('filme', 'generos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $filme = Filme::findOrFail($id);

        $dados = $request->validate([
            'nome' => 'required|string',
            'duracao' => 'nullable|string',
            'data_lancamento' => 'nullable|date',
            'classificacao' => 'nullable|string',
            'sinopse' => 'nullable|string',

            'imagens' => 'nullable',
            'imagens.*' => 'image|mimes:jpeg,png,webp|max:2048',

            'vinculos' => 'nullable|array',
            'vinculos.*.pessoa_id' => 'nullable|integer|exists:pessoas,id',
            'vinculos.*.tipo' => 'nullable|in:ator,diretor,produtor,escritor',
            'vinculos.*.personagem' => 'nullable|string|max:100',

            'remover_vinculos' => 'nullable|array',
            'atores_existentes' => 'nullable|array',
            'atores_existentes.*.papel' => 'nullable|string|max:100',

            'generos' => 'nullable|array',
            'generos.*' => 'exists:generos,id',
        ]);

        // Atualiza dados do filme
        $filme->update([
            'nome' => $dados['nome'],
            'duracao' => $dados['duracao'] ?? null,
            'data_lancamento' => $dados['data_lancamento'] ?? null,
            'classificacao' => $dados['classificacao'] ?? null,
            'sinopse' => $dados['sinopse'] ?? null,
        ]);
        $filme->generos()->sync($request->input('generos', []));

        /*
        |--------------------------------------------------------------------------
        | Remover vínculos
        |--------------------------------------------------------------------------
        */

        if ($request->filled('remover_vinculos.atores')) {
            $filme->atores()->detach($request->input('remover_vinculos.atores'));
        }

        if ($request->filled('remover_vinculos.diretores')) {
            $filme->diretores()->detach($request->input('remover_vinculos.diretores'));
        }

        if ($request->filled('remover_vinculos.produtores')) {
            $filme->produtores()->detach($request->input('remover_vinculos.produtores'));
        }

        if ($request->filled('remover_vinculos.escritores')) {
            $filme->escritores()->detach($request->input('remover_vinculos.escritores'));
        }

        /*
        |--------------------------------------------------------------------------
        | Atualizar personagens existentes
        |--------------------------------------------------------------------------
        */

        foreach ($request->input('atores_existentes', []) as $atorId => $ator) {

            $filme->atores()->updateExistingPivot($atorId, [
                'papel' => $ator['papel'] ?? null
            ]);

        }

        /*
        |--------------------------------------------------------------------------
        | Novos vínculos
        |--------------------------------------------------------------------------
        */

        $this->sincronizarVinculos(
            $filme,
            $request->input('vinculos', [])
        );

        /*
        |--------------------------------------------------------------------------
        | Upload de imagens
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('imagens')) {

            $filme->imagens()->detach();

            $arquivos = $request->file('imagens');

            $posterIndex = $request->input('poster_index', 0);

            foreach ($arquivos as $i => $arquivo) {

                $caminho = $arquivo->store('imagens', 'public');

                $imagem = \App\Models\Imagem::create([
                    'caminho' => $caminho,
                    'nome' => basename($caminho)
                ]);

                $filme->imagens()->attach($imagem->id, [
                    'poster' => ($i == $posterIndex)
                ]);
            }
        }

        return redirect()
            ->route('filmes.show', $filme->id)
            ->with('sucesso', 'Filme atualizado com sucesso!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $filme = Filme::findOrFail($id);

        // Remove vínculos
        $filme->atores()->detach();
        $filme->diretores()->detach();
        $filme->produtores()->detach();
        $filme->escritores()->detach();
        $filme->generos()->detach();
        $filme->estudios()->detach();
        $filme->imagens()->detach();

        // Remove avaliações
        $filme->avaliacoes()->delete();

        // Remove o filme
        $filme->delete();

        return redirect()
            ->route('filmes.index')
            ->with('sucesso', 'Filme removido com sucesso!');
    }
    private function sincronizarVinculos(Filme $filme, array $vinculos): void
    {
        foreach ($vinculos as $v) {

            $pessoaId = $v['pessoa_id'] ?? null;
            $tipo = $v['tipo'] ?? null;
            $personagem = $v['personagem'] ?? null;

            if (!$pessoaId || !$tipo) {
                continue;
            }

            switch ($tipo) {

                case 'ator':

                    $ator = \App\Models\Ator::where('pessoa_id', $pessoaId)->first();

                    if ($ator) {
                        $filme->atores()->syncWithoutDetaching([
                            $ator->id => [
                                'papel' => $personagem
                            ]
                        ]);
                    }

                    break;

                case 'diretor':

                    $diretor = \App\Models\Diretor::where('pessoa_id', $pessoaId)->first();

                    if ($diretor) {
                        $filme->diretores()->syncWithoutDetaching([$diretor->id]);
                    }

                    break;

                case 'produtor':

                    $produtor = \App\Models\Produtor::where('pessoa_id', $pessoaId)->first();

                    if ($produtor) {
                        $filme->produtores()->syncWithoutDetaching([$produtor->id]);
                    }

                    break;

                case 'escritor':

                    $escritor = \App\Models\Escritor::where('pessoa_id', $pessoaId)->first();

                    if ($escritor) {
                        $filme->escritores()->syncWithoutDetaching([$escritor->id]);
                    }

                    break;
            }
        }
    }
}
