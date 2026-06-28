@extends('layouts.app')

@section('titulo', 'Estúdios')

@section('conteudo')

    <div class="mb-4">

        <h1>Estúdios</h1>

        <a href="{{ route('estudios.create') }}" class="btn btn-primary mt-2">
            Novo Estúdio
        </a>

    </div>

    <div class="row g-3">

        @foreach ($estudios as $estudio)

            @php
                $poster = $estudio->imagens->firstWhere('pivot.poster', true);
            @endphp

            <div class="col-md-3">

                <div class="card h-100 shadow-sm">

                    @if($poster)

                        <img src="{{ asset('storage/' . $poster->caminho) }}" class="card-img-top"
                            style="height: 250px; object-fit: cover;">

                    @endif

                    <div class="card-body text-center">

                        <h5>{{ $estudio->nome }}</h5>

                        <p>{{ $estudio->local }}</p>

                        <div class="d-flex justify-content-center gap-2 mt-3">

                            <a href="{{ route('estudios.show', $estudio->id) }}" class="btn btn-info btn-sm">
                                Ver
                            </a>

                            <a href="{{ route('estudios.edit', $estudio->id) }}" class="btn btn-warning btn-sm">
                                Editar
                            </a>

                            <form action="{{ route('estudios.destroy', $estudio->id) }}" method="POST"
                                onsubmit="return confirm('Deseja realmente excluir este estúdio?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    Excluir
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        @endforeach

    </div>




    <div class="mt-4">
        {{ $estudios->links() }}
    </div>

    </div>

@endsection