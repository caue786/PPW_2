<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::orderBy('nome')->get();
        $totalProdutos = Produto::count();

        return view('produtos.index', compact('produtos', 'totalProdutos'));
    }

    public function caros()
    {
        $produtos = DB::table('produtos')
            ->where('preco', '>', 500)
            ->orderBy('preco', 'desc')
            ->get();

        $totalProdutos = $produtos->count();

        return view('produtos.caros', compact('produtos', 'totalProdutos'));
    }

    public function show(int $id)
    {
        $resultado = DB::select('SELECT * FROM produtos WHERE id = ?', [$id]);

        if (empty($resultado)) {
            abort(404);
        }

        return view('produtos.show', ['produto' => $resultado[0]]);
    }

    public function edit(int $id)
    {
        //$resultado = DB::select('SELECT * FROM produtos WHERE id = ?', [$id]);

        

        $produto = Produto::find($id);
        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, int $id)
{
    $dados = $request->validate([
        'nome' => 'required|string',
        'preco' => 'required|numeric',
    ]);

    $produto = Produto::findOrFail($id);

    $produto->update($dados);

    return redirect('/produtos')->with('sucesso', 'Produto atualizado com sucesso!');
}

    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string',
            'preco' => 'required|numeric',
        ]);

        Produto::create($dados);

        return redirect('/produtos')->with('sucesso', 'Produto criado!');
    }

    public function destroy(int $id)
    {
        Produto::findOrFail($id)->delete();

        return redirect('/produtos')->with('sucesso', 'Removido!');
    }
}