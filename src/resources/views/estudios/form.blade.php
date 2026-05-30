{{-- NOME --}}
<div class="mb-3">

    <label class="form-label">
        Nome
    </label>

    <input
        type="text"
        name="nome"
        value="{{ old('nome', $estudio->nome ?? '') }}"
        class="form-control">

</div>

{{-- LOCAL --}}
<div class="mb-3">

    <label class="form-label">
        Local
    </label>

    <input
        type="text"
        name="local"
        value="{{ old('local', $estudio->local ?? '') }}"
        class="form-control">

</div>

{{-- IMAGENS --}}
<div class="mb-3">

    <label class="form-label">
        Imagens
    </label>

    <input
        type="file"
        name="imagens[]"
        multiple
        class="form-control">

</div>

{{-- POSTER --}}
<div class="mb-3">

    <label class="form-label">
        Qual imagem será o poster?
    </label>

    <input
        type="number"
        name="poster_index"
        value="0"
        class="form-control">

</div>

{{-- IMAGENS ATUAIS --}}
@if(isset($estudio) && $estudio->imagens->count())

<div class="mb-3">

    <label class="form-label">
        Imagens atuais
    </label>

    <div class="d-flex flex-wrap gap-3">

        @foreach($estudio->imagens as $img)

            <div>

                <img
                    src="{{ asset('storage/' . $img->caminho) }}"
                    width="120"
                    class="rounded shadow">

                @if($img->pivot->poster)

                    <p class="text-success fw-bold text-center">
                        Poster
                    </p>

                @endif

            </div>

        @endforeach

    </div>

</div>

@endif