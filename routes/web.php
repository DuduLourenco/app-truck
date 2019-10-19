<?php

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

Route::group(["prefix" => "usuarios"], function () {
    Route::get("/login", "UsuariosController@loginView");
    Route::get("/cadastro", "UsuariosController@cadastroView");
    Route::post("/entrar", "UsuariosController@entrar");
    Route::post("/cadastrar", "UsuariosController@cadastrar");
});

Route::group(["prefix" => "veiculos"], function () {
    Route::get("/cadastro", "VeiculosController@cadastroView");
    Route::post("/cadastrar", "VeiculosController@cadastrar");

    Route::group(["prefix" => "/modelos"], function () {
        Route::get("/listModelos/{id}", "ModelosController@listModelosByIdMarca");
    });
});





