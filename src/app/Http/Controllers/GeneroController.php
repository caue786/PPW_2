<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Illuminate\Http\Request;

class GeneroController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->get('busca');

        $generos = Genero::withCount('filmes')
            ->when($busca, function ($query, $busca) {
                return $query->where('nome', 'ilike', "%{$busca}%");
            })
            ->orderBy('nome')
            ->paginate(8)
            ->withQueryString();

        return view('generos.index', compact('generos', 'busca'));
    }

    public function create()
    {
        return view('generos.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'imagem' => 'nullable|image|mimes:jpeg,png,webp|max:2048'
        ]);

        $caminho = null;

        if ($request->hasFile('imagem')) {

            $caminho = $request
                ->file('imagem')
                ->store('generos', 'public');
        }

        Genero::create([
            'nome' => $dados['nome'],
            'imagem' => $caminho
        ]);

        return redirect()
            ->route('generos.index')
            ->with('sucesso', 'Gênero criado com sucesso!');
    }

    public function show(string $id)
    {
        $genero = Genero::findOrFail($id);

        return view('generos.show', compact('genero'));
    }

    public function edit(string $id)
    {
        $genero = Genero::findOrFail($id);

        return view('generos.edit', compact('genero'));
    }

    public function update(Request $request, string $id)
    {
        $genero = Genero::findOrFail($id);

        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'imagem' => 'nullable|image|mimes:jpeg,png,webp|max:2048'
        ]);

        if ($request->hasFile('imagem')) {

            $dados['imagem'] = $request
                ->file('imagem')
                ->store('generos', 'public');
        }

        $genero->update($dados);
        return redirect()
            ->route('generos.index')
            ->with('sucesso', 'Gênero atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $genero = Genero::findOrFail($id);

        $genero->delete();

        return redirect()
            ->route('generos.index')
            ->with('sucesso', 'Gênero removido!');
    }
}