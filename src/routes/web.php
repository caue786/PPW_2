<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\FilmeController;

/*
|ROTAS PÚBLICAS
*/

// Home
Route::get('/', function () {
    return view('home');
})->name('home');


/*
 ROTAS PROTEGIDAS (precisa login)
*/

Route::middleware(['auth'])->group(function () {

    // Filmes (CRUD)
    Route::resource('filmes', FilmeController::class);

    // Exemplo admin
    Route::get('/admin', function () {
        return view('admin');
    });

});

/*rota do admin*/ 
Route::get('/admin', function () {
    return 'Área administrativa';
})->middleware('auth');



/*
 AUTH (BREEZE)
*/

require __DIR__.'/auth.php';