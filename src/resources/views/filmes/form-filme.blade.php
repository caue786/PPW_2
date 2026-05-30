{{-- NOME --}}
<div class="mb-3">
    <label class="form-label">Nome</label>

    <input
        type="text"
        name="nome"
        value="{{ old('nome', $filme->nome ?? '') }}"
        class="form-control">
</div>

{{-- DURAÇÃO --}}
<div class="mb-3">
    <label class="form-label">Duração</label>

    <input
        type="text"
        name="duracao"
        value="{{ old('duracao', $filme->duracao ?? '') }}"
        class="form-control"
        placeholder="Ex: 2h 15min">
</div>

{{-- DATA LANÇAMENTO --}}
<div class="mb-3">
    <label class="form-label">Data de lançamento</label>

    <input
        type="date"
        name="data_lancamento"
        value="{{ old('data_lancamento', $filme->data_lancamento ?? '') }}"
        class="form-control">
</div>

{{-- CLASSIFICAÇÃO --}}
<div class="mb-3">
    <label class="form-label">Classificação</label>

    <input
        type="text"
        name="classificacao"
        value="{{ old('classificacao', $filme->classificacao ?? '') }}"
        class="form-control"
        placeholder="Ex: 14 anos">
</div>

{{-- SINOPSE --}}
<div class="mb-3">
    <label class="form-label">Sinopse</label>

    <textarea
        name="sinopse"
        class="form-control"
        rows="5">{{ old('sinopse', $filme->sinopse ?? '') }}</textarea>
</div>

{{-- IMAGENS --}}
<div class="mb-3">
    <label class="form-label">Imagens</label>

    <input
        type="file"
        name="imagens[]"
        multiple
        class="form-control">
</div>

{{-- ESCOLHER POSTER --}}
<div class="mb-3">
    <label class="form-label">
        Qual imagem será o poster?
    </label>

    <input
        type="number"
        name="poster_index"
        class="form-control"
        value="0">
</div>

{{-- IMAGENS ATUAIS --}}
@if(isset($filme) && $filme->imagens->count())

    <div class="mb-3">

        <label class="form-label">
            Imagens atuais
        </label>

        <div class="d-flex flex-wrap gap-3">

            @foreach($filme->imagens as $img)

                <div>

                    <img
                        src="{{ asset('storage/' . $img->caminho) }}"
                        width="120"
                        class="rounded shadow">

                    @if($img->pivot->poster)

                        <p class="text-success fw-bold text-center mt-1">
                            Poster
                        </p>

                    @endif

                </div>

            @endforeach

        </div>

    </div>

@endif