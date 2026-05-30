<?php

namespace App\Http\Controllers;

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
     * Display a listing of the resource.
     */
    public function index()
    {
        $pessoas = Pessoa::with([
            'ator',
            'diretor',
            'escritor',
            'produtor',
            'imagens'
        ])
            ->orderBy('nome')
            ->paginate(2);

        return view('pessoas.index', compact('pessoas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pessoas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'cpf' => 'required|unique:pessoas',
            'nome' => 'required',
            'data_nascimento' => 'nullable|date',
            'biografia' => 'nullable',
            'genero' => 'nullable',
            'nacionalidade' => 'nullable',

            'imagens' => 'nullable',
            'imagens.*' => 'image|mimes:jpeg,png,webp,jpg|max:2048'
        ]);

        DB::beginTransaction();

        try {

            $pessoa = Pessoa::create([
                'cpf' => $dados['cpf'],
                'nome' => $dados['nome'],
                'data_nascimento' => $dados['data_nascimento'] ?? null,
                'biografia' => $dados['biografia'] ?? null,
                'genero' => $dados['genero'] ?? null,
                'nacionalidade' => $dados['nacionalidade'] ?? null,
            ]);

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

            if ($request->hasFile('imagens')) {

                $arquivos = $request->file('imagens');

                $posterIndex = $request->input('poster_index', 0);

                foreach ($arquivos as $i => $arquivo) {

                    $caminho = $arquivo->store('imagens', 'public');

                    $imagem = Imagem::create([
                        'nome' => basename($caminho),
                        'caminho' => $caminho
                    ]);

                    $pessoa->imagens()->attach(
                        $imagem->id,
                        [
                            'poster' => ($i == $posterIndex)
                        ]
                    );
                }
            }

            DB::commit();

            return redirect()
                ->route('pessoas.index')
                ->with('sucesso', 'Pessoa criada com sucesso!');

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
     * Show the form for editing the specified resource.
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pessoa = Pessoa::findOrFail($id);

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

        $pessoa->update($dados);

        // ATOR
        if ($request->has('ator')) {

            Ator::firstOrCreate([
                'pessoa_id' => $pessoa->id
            ]);

        } else {

            Ator::where('pessoa_id', $pessoa->id)->delete();
        }

        // DIRETOR
        if ($request->has('diretor')) {

            Diretor::firstOrCreate([
                'pessoa_id' => $pessoa->id
            ]);

        } else {

            Diretor::where('pessoa_id', $pessoa->id)->delete();
        }

        // ESCRITOR
        if ($request->has('escritor')) {

            Escritor::firstOrCreate([
                'pessoa_id' => $pessoa->id
            ]);

        } else {

            Escritor::where('pessoa_id', $pessoa->id)->delete();
        }

        // PRODUTOR
        if ($request->has('produtor')) {

            Produtor::firstOrCreate([
                'pessoa_id' => $pessoa->id
            ]);

        } else {

            Produtor::where('pessoa_id', $pessoa->id)->delete();
        }
        if ($request->hasFile('imagens')) {

            // remove vínculos antigos
            $pessoa->imagens()->detach();

            $arquivos = $request->file('imagens');

            $posterIndex = $request->input('poster_index', 0);

            foreach ($arquivos as $i => $arquivo) {

                $caminho = $arquivo->store('imagens', 'public');

                $imagem = Imagem::create([
                    'nome' => basename($caminho),
                    'caminho' => $caminho
                ]);

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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pessoa = Pessoa::findOrFail($id);

        $pessoa->delete();

        return redirect()
            ->route('pessoas.index')
            ->with('sucesso', 'Pessoa removida com sucesso!');
    }
}