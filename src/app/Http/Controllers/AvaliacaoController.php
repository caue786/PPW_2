<?php

namespace App\Http\Controllers;

use App\Models\Estudio;
use App\Models\Avaliacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AvaliacaoController extends Controller
{
    public function index(int $filmeId)
    {
        $avaliacoes = Avaliacao::with('usuario')
            ->where('filme_id', $filmeId)
            ->orderBy('created_at', 'desc')
            ->paginate(2);
        // Se for requisição AJAX (Accept: application/json), retorna JSON
// O paginator serializa automaticamente para JSON com metadados
        return response()->json([
            'data' => $avaliacoes->items(),
            'current_page' => $avaliacoes->currentPage(),
            'last_page' => $avaliacoes->lastPage(),
            'total' => $avaliacoes->total(),
            'next_page_url' => $avaliacoes->nextPageUrl(),
            'prev_page_url' => $avaliacoes->previousPageUrl(),
        ]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'filme_id' => 'required|exists:filmes,id',
            'nota' => 'required|integer|min:1|max:5',
            'descricao' => 'nullable|string'
        ]);

        Avaliacao::updateOrCreate(

            [
                'usuario_id' => auth()->id(),
                'filme_id' => $dados['filme_id']
            ],

            [
                'nota' => $dados['nota'],
                'descricao' => $dados['descricao']
            ]

        );

        return redirect()
            ->back()
            ->with('sucesso', 'Avaliação enviada com sucesso!');
    }

    public function show(string $id)
    {

    }

    public function edit(string $id)
    {

    }

    public function update(Request $request, string $id)
    {

    }

    public function destroy(string $id)
    {

    }
}