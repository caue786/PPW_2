<div class="mb-3">

    <label class="form-label">
        Nome
    </label>

    <input type="text"
           name="nome"
           value="{{ old('nome', $genero->nome ?? '') }}"
           class="form-control">

</div>

<div class="mb-3">

    <label class="form-label">
        Imagem
    </label>

    <input type="file"
           name="imagem"
           class="form-control">

</div>

@if(isset($genero) && $genero->imagem)

    <div class="mt-3">

        <p class="fw-bold">
            Imagem atual:
        </p>

        <img
            src="{{ asset('storage/' . $genero->imagem) }}"
            width="250"
            class="rounded shadow">

    </div>

@endif