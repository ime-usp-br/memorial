<?php

use App\Http\Controllers\FotoController;
use App\Http\Controllers\HomenageadoController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MensagemController;
use App\Http\Controllers\UserController;
use App\Http\Requests\MensagemRequest;

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

Route::get('/', [HomenageadoController::class, 'index']);
Route::resource('/homenageados',HomenageadoController::class);
Route::get('/homenageados/delete/{homenageado_id}', [HomenageadoController::class, 'delete']);
Route::resource('/fotos', FotoController::class);
Route::get('/fotos/create/{homenageado_id}', [FotoController::class, 'create']);
Route::resource('/mensagems', MensagemController::class);
Route::get('/mensagems/create/{homenageado_id}', [MensagemController::class, 'create']);
Route::get('/mensagems/delete/{mensagem_id}', [MensagemController::class, 'delete']);

// Rotas para login
Route::get('login',[LoginController::class, 'redirectToProvider'])->name('login');
Route::get('callback', [LoginController::class, 'handleProviderCallback']);
Route::post('logout',[LoginController::class, 'logout'])->name('logout');

//Rotas para adicionar um novo administrador
Route::get('/admin', [UserController::class, 'showAdmins']);
Route::post('/admin/novoadmin', [UserController::class, 'registerAdmin']);
Route::get('/admin/removerAdmin/{admin_id}', [UserController::class, 'removerAdmin']);

//Rotas para adicionar um novo curador
Route::get('/admin/novocurador/{homenageado_id}', [UserController::class, 'formCurador']);
Route::post('/admin/novocurador', [UserController::class, 'registerCurador']);

//Rotas para remover um curador
Route::get('/admin/removercurador/{curador_id}/{homenageado_id}', [UserController::class, 'removerCurador']);

Route::get('/curador/homenageados/{curador_codpes}', [UserController::class, 'showHomenageadosCurador']);

Route::get('/mensagems/validar/{msg_id}', [MensagemController::class, 'formValidarMensagem']);
Route::get('/mensagems/validar/{msg_id}/{validacao}', [MensagemController::class, 'validarMensagem']);

