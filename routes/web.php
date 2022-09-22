<?php

use App\Http\Controllers\CargoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EfectivoController;
use App\Http\Controllers\HablitacaoController;
use App\Http\Controllers\PermissaoController;
use App\Http\Controllers\PresencaController;
use App\Http\Controllers\PromocoesController;
use App\Http\Controllers\QuadroespecialController;
use App\Http\Controllers\SubcategoriaController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::resources([
    'unidades' => UnidadeController::class,
    'categorias' => CategoriaController::class,
    'subcategoria' => SubcategoriaController::class,
    'permissao' => PermissaoController::class,
    'cargo' => CargoController::class,
    'user' => UserController::class,
    'quadro_especial' => QuadroespecialController::class,
    'efectivos' => EfectivoController::class,
    'hablitacao' =>HablitacaoController::class,
    'promocoes' => PromocoesController::class,
    'presenca' => PresencaController::class,
    ]);


Route::get('/imprimirListaEfectivos/{unidade}', [App\Http\Controllers\UnidadeController::class,'imprimirListaEfectivos'])->name('imprimirListaEfectivos');
Route::post('categoriasGetsubcategorias/{categoria}', [App\Http\Controllers\CategoriaController::class,'getSubcategorias'])->name('categorias.subcategorias');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});



