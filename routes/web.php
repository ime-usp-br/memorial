<?php

use App\Http\Controllers\FotoController;
use App\Http\Controllers\HomenageadoController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MensagemController;
use App\Http\Controllers\UserController;

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

Route::get('/', [IndexController::class, 'index']);
Route::resource('/homenageados',HomenageadoController::class);
Route::resource('/fotos', FotoController::class);
Route::get('/fotos/create/{homenageado_id}', [FotoController::class, 'create']);
Route::resource('/mensagems', MensagemController::class);
Route::get('/mensagems/create/{homenageado_id}', [MensagemController::class, 'create']);

// Rotas para login
Route::get('login',[LoginController::class, 'redirectToProvider'])->name('login');
Route::get('callback', [LoginController::class, 'handleProviderCallback']);
Route::post('logout',[LoginController::class, 'logout'])->name('logout');

//Rotas para adicionar um novo administrador
Route::get('/novoadmin', [UserController::class, 'formAdmin']);
Route::post('/novoadmin', [UserController::class, 'registerAdmin']);

//Rotas para adicionar um novo curador
Route::get('/novocurador/{homenageado_id}', [UserController::class, 'formCurador']);
Route::post('/novocurador', [UserController::class, 'registerCurador']);

//Rotas para remover um curador
Route::get('/admin/removercurador/{homenageado_id}', [UserController::class, 'formRemoverCurador']);
Route::post('/admin/removercurador', [UserController::class, 'removerCurador']);

