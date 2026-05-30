<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filme;
use App\Models\Pessoa;
use App\Models\Estudio;
use App\Models\Genero;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->get('busca');

        $filmes = collect();
        $pessoas = collect();
        $estudios = collect();
        $generos = collect();

        if ($busca) {

            $filmes = Filme::with('imagens')
                ->where('nome', 'ilike', "%{$busca}%")
                ->get();

            $pessoas = Pessoa::with([
                'ator',
                'diretor',
                'escritor',
                'produtor',
                'imagens'
            ])
                ->where('nome', 'ilike', "%{$busca}%")
                ->get();

            $estudios = Estudio::with('imagens')
                ->where('nome', 'ilike', "%{$busca}%")
                ->get();

            $generos = Genero::where(
                'nome',
                'ilike',
                "%{$busca}%"
            )->get();
        }

        return view('home', compact(
            'filmes',
            'pessoas',
            'estudios',
            'generos',
            'busca'
        ));
    }
}