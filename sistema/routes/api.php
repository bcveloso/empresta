<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', 'API\AuthController@login');

// Rotas com autenticação
/*
Route::group(['middleware' => ['apiJwt']], function(){
    Route::get('instituicoes', 'API\InstituicoesController@index');
    Route::get('convenios','API\ConveniosController@index');
    Route::post('simulacao','API\SimulacaoController@index');
});
*/

// Rotas sem autenticação

Route::get('instituicoes', 'API\InstituicoesController@index');
Route::get('convenios','API\ConveniosController@index');
Route::post('simulacao','API\SimulacaoController@index');

