<?php

use App\Http\Controllers\UsuarioControlador;
use App\Http\Middleware\PrimeiroMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

// Route::get('/usuarios','App\Http\Controllers\UsuarioControlador@index')
//     // ->middleware(PrimeiroMiddleware::class);
//     ->middleware('primeiro'); //definido no Kernel.php

//passando o middleware no controller ou kernel middlewareGroups web:
// Route::get('/usuarios','App\Http\Controllers\UsuarioControlador@index');
 
Route::get('/usuarios','App\Http\Controllers\UsuarioControlador@index')
    ->middleware('primeiro', 'segundo');

Route::get('/terceiro', function(){
    return "passou pelo terceiro middleware";
})->middleware('terceiro:karol'); //passando parâmetro

Route::get('/produtos', 'App\Http\Controllers\ProdutoController@index');

Route::get('/negado', function(){
    return "Acesso negado! Você precisa estar logado para acessar esta página.";
})->name('negado');

Route::get('/negadoadmin', function(){
    return "Prezado usuário, você precisa ser administrador para acessar este conteúdo.";
})->name('negadoadmin');

Route::post('/login', function(Request $request){
    $login_ok = false;
    $admin = false;

    switch($request->input('user')){
        case 'joao':
            $login_ok = $request->input('passwd') === "senhajoao";
            $admin = true;
            break;
        case 'marcos':
            $login_ok = $request->input('passwd') === "senhamarcos";
            break;
        default:
            $login_ok = false;
    }

    if($login_ok){
        $login = ['user' => $request->input('user'), 'admin' => $admin];
        $request->session()->put('login', $login);
        return response('Login ok', 200);
    }

    $request->session()->flush();
    return response('Erro login', 404);
});

Route::get('logout', function(Request $request){
    $request->session()->flush();
    return response('Deslogado com sucesso!', 200);
});