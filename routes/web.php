<?php

use App\Http\Controllers\ClienteControlador;
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

Route::get('/', function() {
    return view('index');
});

Route::get('/produtos', 'App\Http\Controllers\ControladorProduto@indexView');
Route::get('categorias/apagar/{id}', 'App\Http\Controllers\ControladorCategoria@destroy');
Route::resource('categorias', 'App\Http\Controllers\ControladorCategoria');


