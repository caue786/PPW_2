<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filme;
use App\Models\Pessoa;
use App\Models\Estudio;
use App\Models\Genero;
use App\Models\Avaliacao;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->get('busca');

        // Inicializa as coleções
        $estudios = collect();
        $generos = collect();
        $avaliacoes = collect();

        if ($busca) {

            // Pesquisa

            $filmes = Filme::with('imagens')
                ->where('nome', 'ilike', "%{$busca}%")
                ->get();

            $pessoas = Pessoa::with([
                'imagens',
                'ator',
                'diretor',
                'escritor',
                'produtor'
            ])
                ->where('nome', 'ilike', "%{$busca}%")
                ->get();

        } else {

            // Página inicial

            $filmes = Filme::with('imagens')
                ->paginate(6, ['*'], 'filmes');

            $pessoas = Pessoa::with([
                'imagens',
                'ator',
                'diretor',
                'escritor',
                'produtor'
            ])->paginate(4, ['*'], 'pessoas');

            $avaliacoes = Avaliacao::with([
                'usuario',
                'filme'
            ])
                ->latest()
                ->take(9)
                ->get();
        }

        return view('home', compact(
            'filmes',
            'pessoas',
            'estudios',
            'generos',
            'avaliacoes',
            'busca'
        ));
    }
}

