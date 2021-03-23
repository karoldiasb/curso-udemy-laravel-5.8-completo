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

Route::get('produtos', function() {
    return view('outras.produtos');
})->name('produtos');

Route::get('departamentos', function() {
    return view('outras.departamentos');
})->name('departamentos');

Route::resource('clientes', ClienteControlador::class);

Route::get('bootstrap', function() {
    return view('outras.exemplo');
})->name('exemplo-bootstrap');

