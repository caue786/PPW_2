<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filme;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class FilmeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $busca = $request->get('busca');

    $filmes = Filme::with('imagens')
        ->when($busca, function ($query, $busca) {
            return $query->where('nome', 'ilike', "%{$busca}%");
        })
        ->orderBy('nome')
        ->paginate(2)
        ->withQueryString();

    return view('filmes.index', compact('filmes', 'busca'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('filmes.create');
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

        'imagens.*' => 'image|mimes:jpeg,png,webp|max:2048'

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
        $filme = Filme::findOrFail($id);

        $avaliacoes = $filme->avaliacoes()
            ->with('usuario')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('filmes.show', compact('filme', 'avaliacoes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        // Somente admin pode editar
        abort_unless(auth()->check(), 403);
        $filme = Filme::findOrFail($id);
        return view('filmes.edit', compact('filme'));
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
        'imagens.*' => 'image|mimes:jpeg,png,webp|max:2048'
    ]);

    $filme->update([
        'nome' => $dados['nome'],
        'duracao' => $dados['duracao'] ?? null,
        'data_lancamento' => $dados['data_lancamento'] ?? null,
        'classificacao' => $dados['classificacao'] ?? null,
        'sinopse' => $dados['sinopse'] ?? null,
    ]);

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
        //
    }
}
