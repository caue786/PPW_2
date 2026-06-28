<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\EstudioController;
use App\Http\Controllers\AvaliacaoController;

/*
|--------------------------------------------------------------------------
| ROTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// Filmes públicos
Route::get('/filmes-p/{id}', [FilmeController::class, 'indexPublic'])
    ->name('filmes.public');

// Pessoas públicas
Route::get('/pessoas-p/{id}', [PessoaController::class, 'showPublic'])
    ->name('pessoas.public');

// Buscar avaliações de um filme
Route::get(
    '/filmes/{filme}/avaliacoes',
    [AvaliacaoController::class, 'index']
)->name('avaliacoes.index');


/*
|--------------------------------------------------------------------------
| ROTAS PARA QUALQUER USUÁRIO LOGADO
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Salvar avaliações
    Route::post(
        '/avaliacoes',
        [AvaliacaoController::class, 'store']
    )->name('avaliacoes.store');

});


/*
|--------------------------------------------------------------------------
| ROTAS APENAS PARA ADMINISTRADORES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin', function () {
        return view('admin');
    })->name('admin');

    Route::get('/pessoas/buscar', [PessoaController::class, 'buscar'])
        ->name('pessoas.buscar');

    Route::resource('pessoas', PessoaController::class);

    Route::resource('filmes', FilmeController::class);

    Route::resource('generos', GeneroController::class);

    Route::resource('estudios', EstudioController::class);

});


/*
|--------------------------------------------------------------------------
| AUTH (Laravel Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';