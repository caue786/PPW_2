@extends('layouts.app')

@section('titulo', 'Alterar produto')

@section('conteudo')
    <h1 class="mb-4">Alterar Produto</h1>

    <form action="/produtos/{{ $produto->id }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input id="nome" type="text" name="nome" class="form-control" required
                value="{{ old('nome', $produto->nome) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Preço</label>
            <input type="number" id="preco" step="0.01" name="preco" class="form-control" required
                value="{{ old('preco', $produto->preco) }}">
        </div>

        <button type="submit" class="btn btn-success">
            Salvar
        </button>

        <a href="/produtos" class="btn btn-secondary">
            Voltar
        </a>
    </form>
@endsection