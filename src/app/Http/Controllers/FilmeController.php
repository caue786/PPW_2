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
    public function index()
{
    $filmes = Filme::all();

    return view('filmes.index', compact('filmes'));
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

        'poster' => 'required|image|mimes:jpeg,png,webp|max:2048'
    ]);

    DB::beginTransaction();

    try {

        $caminhoPoster = $request
            ->file('poster')
            ->store('posters', 'public');

        $dados['poster_url'] = $caminhoPoster;

        Filme::create($dados);

        DB::commit();

        return redirect('/filmes');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with('erro', 'Erro ao salvar filme');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
{
    $filme = Filme::findOrFail($id);

    $dados = $request->validate([

        'nome' => 'required|string',

        'poster' => 'sometimes|nullable|image|mimes:jpeg,png,webp|max:2048'
    ]);

    if ($request->hasFile('poster')) {

        if ($filme->poster_url) {

            Storage::disk('public')
                ->delete($filme->poster_url);
        }

        $dados['poster_url'] = $request
            ->file('poster')
            ->store('posters', 'public');
    }

    $filme->update($dados);

    return redirect('/filmes');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
