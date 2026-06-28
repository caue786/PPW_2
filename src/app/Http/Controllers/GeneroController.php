<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Illuminate\Http\Request;

class GeneroController extends Controller
{
    /**
     * Lista todos os gêneros cadastrados.
     * Também permite realizar busca pelo nome.
     */
    public function index(Request $request)
    {
        // Obtém o texto digitado no campo de pesquisa.
        $busca = $request->get('busca');

        // Busca os gêneros juntamente com a quantidade de filmes
        // relacionados a cada um.
        $generos = Genero::withCount('filmes')

            // Executa a pesquisa somente se houver um termo informado.
            ->when($busca, function ($query, $busca) {
                return $query->where('nome', 'ilike', "%{$busca}%");
            })

            // Ordena alfabeticamente.
            ->orderBy('nome')

            // Pagina os resultados.
            ->paginate(8)

            // Mantém o termo da busca ao trocar de página.
            ->withQueryString();

        return view('generos.index', compact('generos', 'busca'));
    }

    /**
     * Exibe o formulário de cadastro.
     */
    public function create()
    {
        return view('generos.create');
    }

    /**
     * Salva um novo gênero.
     */
    public function store(Request $request)
    {
        // Valida os dados enviados pelo formulário.
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'imagem' => 'nullable|image|mimes:jpeg,png,webp|max:2048'
        ]);

        $caminho = null;

        // Verifica se foi enviada uma imagem.
        if ($request->hasFile('imagem')) {

            // Salva a imagem na pasta "generos".
            $caminho = $request
                ->file('imagem')
                ->store('generos', 'public');
        }

        // Cria o registro do gênero.
        Genero::create([
            'nome' => $dados['nome'],
            'imagem' => $caminho
        ]);

        return redirect()
            ->route('generos.index')
            ->with('sucesso', 'Gênero criado com sucesso!');
    }

    /**
     * Exibe os detalhes de um gênero.
     */
    public function show(string $id)
    {
        // Procura o gênero pelo ID.
        $genero = Genero::findOrFail($id);

        return view('generos.show', compact('genero'));
    }

    /**
     * Exibe o formulário de edição.
     */
    public function edit(string $id)
    {
        // Localiza o gênero que será editado.
        $genero = Genero::findOrFail($id);

        return view('generos.edit', compact('genero'));
    }

    /**
     * Atualiza os dados do gênero.
     */
    public function update(Request $request, string $id)
    {
        // Busca o gênero pelo ID.
        $genero = Genero::findOrFail($id);

        // Valida os dados recebidos.
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'imagem' => 'nullable|image|mimes:jpeg,png,webp|max:2048'
        ]);

        // Caso uma nova imagem seja enviada,
        // substitui o caminho da imagem anterior.
        if ($request->hasFile('imagem')) {

            $dados['imagem'] = $request
                ->file('imagem')
                ->store('generos', 'public');
        }

        // Atualiza o registro no banco de dados.
        $genero->update($dados);

        return redirect()
            ->route('generos.index')
            ->with('sucesso', 'Gênero atualizado com sucesso!');
    }

    /**
     * Remove um gênero do sistema.
     */
    public function destroy(string $id)
    {
        // Localiza o gênero.
        $genero = Genero::findOrFail($id);

        // Exclui o registro.
        $genero->delete();

        return redirect()
            ->route('generos.index')
            ->with('sucesso', 'Gênero removido!');
    }
}