@extends('layouts.app')

@section('titulo', $pessoa->nome)

@section('conteudo')

    <div class="container mt-5">

        <div class="card shadow p-4">

            @php
                $poster = $pessoa->imagens->firstWhere('pivot.poster', true);
            @endphp

            <div class="row">

                <div class="col-md-4 text-center">

                    @if($poster)

                        <img src="{{ asset('storage/' . $poster->caminho) }}" class="img-fluid rounded shadow"
                            alt="{{ $pessoa->nome }}">

                    @else

                        <img src="{{ asset('images/sem-foto.jpg') }}" class="img-fluid rounded shadow" alt="Sem foto">

                    @endif

                </div>

                <div class="col-md-8">

                    <h1>{{ $pessoa->nome }}</h1>

                    <p>
                        <strong>CPF:</strong>
                        {{ $pessoa->cpf }}
                    </p>

                    <p>
                        <strong>Data Nascimento:</strong>
                        {{ $pessoa->data_nascimento }}
                    </p>

                    <p>
                        <strong>Gênero:</strong>
                        {{ $pessoa->genero }}
                    </p>

                    <p>
                        <strong>Nacionalidade:</strong>
                        {{ $pessoa->nacionalidade }}
                    </p>

                    <p>
                        <strong>Biografia:</strong>
                        {{ $pessoa->biografia }}
                    </p>

                    <hr>

                    <h4>Funções</h4>

                    @if($pessoa->ator)
                        <span class="badge bg-primary">Ator</span>
                    @endif

                    @if($pessoa->diretor)
                        <span class="badge bg-success">Diretor</span>
                    @endif

                    @if($pessoa->escritor)
                        <span class="badge bg-warning text-dark">Escritor</span>
                    @endif

                    @if($pessoa->produtor)
                        <span class="badge bg-danger">Produtor</span>
                    @endif

                </div>

            </div>

        </div>

@endsection