<?php

namespace App\Http\Controllers;

use App\Models\Estudio;
use App\Models\Imagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstudioController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->get('busca');

        $estudios = Estudio::with('imagens')
            ->when($busca, function ($query, $busca) {
                return $query->where('nome', 'ilike', "%{$busca}%");
            })
            ->orderBy('nome')
            ->paginate(3)
            ->withQueryString();

        return view('estudios.index', compact('estudios', 'busca'));
    }

    public function create()
    {
        return view('estudios.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([

            'nome' => 'required|string|max:255',

            'local' => 'nullable|string|max:255',

            'imagens' => 'required',

            'imagens.*' => 'image|mimes:jpeg,png,webp|max:2048'

        ]);

        DB::beginTransaction();

        try {

            $estudio = Estudio::create([

                'nome' => $dados['nome'],

                'local' => $dados['local'] ?? null

            ]);

            $arquivos = $request->file('imagens');

            $posterIndex = $request->input('poster_index', 0);

            foreach ($arquivos as $i => $arquivo) {

                $caminho = $arquivo->store('imagens', 'public');

                $imagem = Imagem::create([

                    'caminho' => $caminho,

                    'nome' => basename($caminho)

                ]);

                $estudio->imagens()->attach($imagem->id, [

                    'poster' => ($i == $posterIndex)

                ]);
            }

            DB::commit();

            return redirect()
                ->route('estudios.index')
                ->with('sucesso', 'Estúdio criado!');

        } catch (\Exception $e) {

            DB::rollBack();

            dd($e);
        }
    }

    public function show(string $id)
    {
        $estudio = Estudio::with('imagens')->findOrFail($id);

        return view('estudios.show', compact('estudio'));
    }

    public function edit(string $id)
    {
        $estudio = Estudio::with('imagens')->findOrFail($id);

        return view('estudios.edit', compact('estudio'));
    }

    public function update(Request $request, string $id)
    {
        $estudio = Estudio::findOrFail($id);

        $dados = $request->validate([

            'nome' => 'required|string|max:255',

            'local' => 'nullable|string|max:255',

            'imagens.*' => 'nullable|image|mimes:jpeg,png,webp|max:2048'

        ]);

        $estudio->update([

            'nome' => $dados['nome'],

            'local' => $dados['local'] ?? null

        ]);

        if ($request->hasFile('imagens')) {

            $arquivos = $request->file('imagens');

            $posterIndex = $request->input('poster_index', 0);

            foreach ($arquivos as $i => $arquivo) {

                $caminho = $arquivo->store('imagens', 'public');

                $imagem = Imagem::create([

                    'caminho' => $caminho,

                    'nome' => basename($caminho)

                ]);

                $estudio->imagens()->attach($imagem->id, [

                    'poster' => ($i == $posterIndex)

                ]);
            }
        }

        return redirect()
            ->route('estudios.index')
            ->with('sucesso', 'Estúdio atualizado!');
    }

    public function destroy(string $id)
    {
        $estudio = Estudio::findOrFail($id);

        $estudio->delete();

        return redirect()
            ->route('estudios.index')
            ->with('sucesso', 'Estúdio removido!');
    }
}