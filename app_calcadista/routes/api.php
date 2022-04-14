<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

if (!defined('VERSAO_API')) define('VERSAO_API', 'v1/');
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

Route::post(VERSAO_API . 'auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['apiJwt']], function (){
    // ******************** Inicio das rotas para usuários da API ********************
    Route::post (VERSAO_API . 'auth/logout', 'App\Http\Controllers\Api\AuthController@logout');
    Route::post(VERSAO_API. 'auth/refresh', 'App\Http\Controllers\Api\AuthController@refresh');
    Route::get(VERSAO_API . 'users', 'App\Http\Controllers\Api\UserController@index');

    // ******************** Inicio das rotas para a empresa Calçadista ********************
    Route::get(VERSAO_API. 'pedidos/{idUser}', 'App\Http\Controllers\calcadista\controlePedido@show');
    Route::post(VERSAO_API. 'pedidos/alteracao','App\Http\Controllers\calcadista\controlePedido@update');

    Route::get(VERSAO_API. 'lotes', 'App\Http\Controllers\calcadista\controleLote@index');
    Route::get(VERSAO_API. 'lotes/{idLote}', 'App\Http\Controllers\calcadista\controleLote@show');

    Route::get(VERSAO_API. 'produtos', 'App\Http\Controllers\calcadista\controleProduto@index');
    Route::get(VERSAO_API. 'produtos/{idProduto}', 'App\Http\Controllers\calcadista\controleProduto@show');
    Route::post(VERSAO_API. 'pedidos/alteracao','App\Http\Controllers\calcadista\controleProduto@update');

    Route::get(VERSAO_API. 'clientes', 'App\Http\Controllers\calcadista\controleCliente@index');
    Route::get(VERSAO_API. 'clientes/{idCliente}', 'App\Http\Controllers\calcadista\controleCliente@show');

    Route::get(VERSAO_API. 'notaFiscal', 'App\Http\Controllers\calcadista\controleNotaFiscal@index');
    Route::get(VERSAO_API. 'notaFiscal/{idNota}', 'App\Http\Controllers\calcadista\controleNotaFiscal@show');

});
