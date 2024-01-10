<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\LivroController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AluguelController;

Route::get('/livros', [LivroController::class, 'buscaLivros']);
Route::get('/livro/{id}', [LivroController::class, 'buscaLivro']);
Route::put('/livro/{id}', [LivroController::class, 'atualizaLivro']);
Route::post('/livro', [LivroController::class, 'salvaLivro']);
Route::delete('/livro/{id}', [LivroController::class, 'deletaLivro']);

Route::get('/usuarios', [UsuarioController::class, 'buscaUsuarios']);
Route::get('/usuario/{id}', [UsuarioController::class, 'buscaUsuario']);
Route::put('/usuario/{id}', [UsuarioController::class, 'atualizaUsuario']);
Route::post('/usuario', [UsuarioController::class, 'salvaUsuario']);
Route::delete('/usuario/{id}', [UsuarioController::class, 'deletaUsuario']);

Route::get('/alugueis', [AluguelController::class, 'buscaAlugueis']);
Route::get('/aluguel/{id}', [AluguelController::class, 'buscaAluguel']);
Route::put('/aluguel/{id}', [AluguelController::class, 'atualizaAluguel']);
Route::post('/aluguel', [AluguelController::class, 'salvaAluguel']);
Route::delete('/aluguel/{id}', [AluguelController::class, 'deletaAluguel']);
