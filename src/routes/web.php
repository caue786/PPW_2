<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\EstudioController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\HomeController;
/*
| ROTAS PÚBLICAS
*/

// Home
Route::get('/', [HomeController::class, 'index'])
    ->name('home');


/*
| ROTAS PROTEGIDAS (precisa login)
*/

Route::middleware(['auth'])->group(function () {

    // Filmes (CRUD)
    Route::resource('filmes', FilmeController::class);
    //rotas para Genero 
    Route::resource('generos', GeneroController::class);
    //rotas para estudios 
    Route::resource('estudios',EstudioController::class);
    //rotas de Pessoas
    Route::resource('pessoas',PessoaController::class);
    // Admin (protegido)
    Route::get('/admin', function () {
        return view('admin'); // depois você estiliza
    })->name('admin');

});


/*
| AUTH (BREEZE)
*/
require __DIR__.'/auth.php';