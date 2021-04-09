<?php

use App\Http\Controllers\ClienteControlador;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Desenvolvedor;
use App\Models\Endereco;
use App\Models\Produto;
use App\Models\Projeto;
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

Route::get('/clientes/json', function() {
    // $clientes = Cliente::all();
    $clientes = Cliente::with(['endereco'])->get(); //carrega os relacionamentos tb
    return $clientes->toJson();
});
Route::resource('clientes', ClienteControlador::class);

Route::get('bootstrap', function() {
    return view('outras.exemplo');
})->name('exemplo-bootstrap');

//----- Aplicando relacionamento 1 PARA 1
Route::get('/clientes', function(){
    $clientes = Cliente::all();
    foreach($clientes as $cliente){
        echo "<h3>dados do cliente</h3>";
        echo "<p> id: ". $cliente->id . "</p>";
        echo "<p> Nome: ". $cliente->nome . "</p>";
        echo "<p> Telefone: ". $cliente->telefone . "</p>";
        echo "<h3>endereço do cliente</h3>";
        // echo "<p> Rua: ". $cliente->endereco->rua . "</p>";
        // echo "<p> Número: ". $cliente->endereco->numero . "</p>";
        // echo "<p> Bairro: ". $cliente->endereco->bairro . "</p>";
        // echo "<p> Cidade: ". $cliente->endereco->cidade . "</p>";
        // echo "<p> UF: ". $cliente->endereco->uf . "</p>";
        // echo "<p> CEP: ". $cliente->endereco->cep . "</p>";
    }
});

Route::get('/enderecos', function(){
    $enderecos = Endereco::all();
    foreach($enderecos as $endereco){
        echo "<p> id cliente: ". $endereco->cliente_id . "</p>";
        echo "<p> Nome: ". $endereco->cliente->nome . "</p>";
        echo "<p> Telefone: ". $endereco->cliente->telefone . "</p>";
        echo "<p> Rua: ". $endereco->rua . "</p>";
        echo "<p> Número: ". $endereco->numero . "</p>";
        echo "<p> Bairro: ". $endereco->bairro . "</p>";
        echo "<p> Cidade: ". $endereco->cidade . "</p>";
        echo "<p> UF: ". $endereco->uf . "</p>";
        echo "<p> CEP: ". $endereco->cep . "</p>";
    }
});

Route::get('/enderecos/json', function() {
    // $enderecos = Endereco::all();
    $enderecos = Endereco::with(['cliente'])->get(); //carrega os relacionamentos tb
    return $enderecos->toJson();
});

Route::get('/inserir', function(){
    
    $c = new Cliente();
    $c->nome = "fulano";
    $c->telefone = "637777777";
    $c->save();

    $e = new Endereco();
    $e->rua = 2;
    $e->numero = 1;
    $e->bairro = "bairro";
    $e->cidade = "cidade";
    $e->uf = "uf";
    $e->cep = "cep";

    $c->endereco()->save($e);
});

// ---- Fim aplicando relacionamento 1 PARA 1

//----- Aplicando relacionamento 1 PARA MUITOS
Route::get('/categorias', function(){
    $cats = Categoria::all();
    if(count($cats) === 0){
        echo "<h4>Não há categorias </h4>";
    }else{
        foreach($cats as $c){
            echo "<p>" . $c->id . " - " . $c->nome . "</p>";
        }
    }
});

Route::get('/produtos', function(){
    $prods = Produto::all();
    if(count($prods) === 0){
        echo "<h4>Não há produtos </h4>";
    }else{
        foreach($prods as $p){
            echo "<p>" . $p->id . " - " . $p->nome . " - " . $p->preco . " - " . $p->categoria->nome . "</p>";
        }
    }
});

Route::get('/categoriasprodutos', function(){
    $cats = Categoria::all();
    if(count($cats) === 0){
        echo "<h4>Não há categorias </h4>";
    }else{
        foreach($cats as $c){
            echo "<p>" . $c->id . " - " . $c->nome . "</p>";
        
            $prods = $c->produtos;
            if(count($prods) > 0){
                echo '<ul>';
                    foreach($prods as $p){
                        echo '<li>' . $p->nome . '</li>';
                    }
                echo '</ul>';

            }
        }
    }
});

Route::get('/categoriasprodutos/json', function() {
    $cats = Categoria::with(['produtos'])->get(); //carrega os relacionamentos tb
    return $cats->toJson();
});

Route::get('/adicionarproduto', function() {
    $cat = Categoria::find(1);
    $p = new Produto();
    $p->nome = "Meu novo produto";
    $p->estoque = 3;
    $p->preco = 100;
    // $p->categora_id = 1;
    $p->categoria()->associate($cat);
    $p->save();
    return $p->toJson();
});

Route::get('/removerprodutocategoria', function() {
    $p = Produto::find(11);
    if(isset($p)){
        $p->categoria()->dissociate();
        $p->save();
        return $p->toJson();
    }
    return '';
});

Route::get('/adicionarproduto/{cat}', function($catid) {
    $cat = Categoria::with('produtos')->find($catid);
    $p = new Produto();
    $p->nome = "Meu novo produto com load";
    $p->estoque = 2;
    $p->preco = 200;
    // $p->categora_id = 1;

    if(isset($cat)){
        $cat->produtos()->save($p);
    }

    $cat->load('produtos');
    return $cat->toJson();
});
//----- Fim aplicando relacionamento 1 PARA MUITOS

//----- Aplicando relacionamento MUITOS PARA MUITOS
Route::get('/desenvolvedor_projetos', function() {
    $devs = Desenvolvedor::with('projetos')->get(); 
    // return $devs->toJson();

    foreach($devs as $d){
        echo "<p> Nome do Desenvolvedor: " . $d->nome . "</p>";
        echo "<p> Cargo: " . $d->cargo . "</p>";
        if(count($d->projetos) > 0){
            echo "Protejos: <br>";
            echo "<ul>";
            foreach($d->projetos as $p){
                echo "<li>";
                echo "Nome: " . $p->nome . " | " ;
                echo "Horas do projeto: " . $p->estimativa_horas . " | " ;
                echo "Horas trabalhadas: " . $p->pivot->horas_semanais . " | " ;
                echo "</li>";
            }
            echo "</ul>";
        }
        echo "<hr>";
    }
});

Route::get('/projeto_desenvolvedores', function() {
    $projetos = Projeto::with('desenvolvedores')->get(); 
    return $projetos->toJson();
});

Route::get('/alocar', function() {
    $projeto = Projeto::find(4);
    if(isset($projeto)){
        $projeto->desenvolvedores()->attach(1, ['horas_semanais' => 50]);
        $projeto->desenvolvedores()->attach(2, ['horas_semanais' => 20]);
        $projeto->desenvolvedores()->attach(3, ['horas_semanais' => 10]);
        // $projeto->desenvolvedores()->attach([
        //     1, ['horas_semanais' => 50],
        //     2, ['horas_semanais' => 20],
        //     3, ['horas_semanais' => 10]
        // ]);
    }
});

Route::get('/desalocar', function() {
    $projeto = Projeto::find(4);
    if(isset($projeto)){
        // $projeto->desenvolvedores()->attach(1, ['horas_semanais' => 50]);
        $projeto->desenvolvedores()->detach([1,2,3]);
    }
});