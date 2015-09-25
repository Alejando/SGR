<?php
use App\Cliente;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin', function () {
    return view('m_admin');
});
Route::get('vendedor', function () {
    return view('m_vendedor');
});
Route::get('login', function () {
    return view('c_sesion');
});
Route::get('clientes', function () {
    $clientes = Cliente::all();

    return ($clientes);
});