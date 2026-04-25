<?php

use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;
Route::get('/produtos/caros', [ProdutoController::class, 'caros']);
Route::resource('produtos', ProdutoController::class);

