<div class="mb-3">
    <label>CPF</label>
    <input type="text" name="cpf" value="{{ old('cpf', $pessoa->cpf ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label>Nome</label>
    <input type="text" name="nome" value="{{ old('nome', $pessoa->nome ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label>Data Nascimento</label>
    <input type="date" name="data_nascimento" value="{{ old('data_nascimento', $pessoa->data_nascimento ?? '') }}"
        class="form-control">
</div>

<div class="mb-3">
    <label>Biografia</label>
    <textarea name="biografia" class="form-control">{{ old('biografia', $pessoa->biografia ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label>Gênero</label>
    <input type="text" name="genero" value="{{ old('genero', $pessoa->genero ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label>Nacionalidade</label>
    <input type="text" name="nacionalidade" value="{{ old('nacionalidade', $pessoa->nacionalidade ?? '') }}"
        class="form-control">
</div>

<hr>

<div class="form-check">
    <input type="checkbox" name="ator" class="form-check-input" {{ isset($pessoa) && $pessoa->ator ? 'checked' : '' }}>
    <label class="form-check-label">
        Ator
    </label>
</div>

<div class="form-check">
    <input type="checkbox" name="diretor" class="form-check-input" {{ isset($pessoa) && $pessoa->diretor ? 'checked' : '' }}>
    <label class="form-check-label">
        Diretor
    </label>
</div>

<div class="form-check">
    <input type="checkbox" name="escritor" class="form-check-input" {{ isset($pessoa) && $pessoa->escritor ? 'checked' : '' }}>
    <label class="form-check-label">
        Escritor
    </label>
</div>

<div class="form-check">
    <input type="checkbox" name="produtor" class="form-check-input" {{ isset($pessoa) && $pessoa->produtor ? 'checked' : '' }}>
    <label class="form-check-label">
        Produtor
    </label>
</div>


@if(isset($pessoa))

    @php
        $poster = $pessoa->imagens->firstWhere('pivot.poster', true);
    @endphp

    @if($poster)

        <div class="mb-3">

            <img src="{{ asset('storage/' . $poster->caminho) }}" class="img-thumbnail" style="max-width:200px;">

        </div>

    @endif

@endif

<div class="mb-3">
    <label class="form-label">Imagens</label>

    <input type="file" name="imagens[]" multiple class="form-control">
</div>

<div class="mb-3">
    <label class="form-label">Qual imagem será a principal?</label>

    <input type="number" name="poster_index" value="0" class="form-control">
</div>