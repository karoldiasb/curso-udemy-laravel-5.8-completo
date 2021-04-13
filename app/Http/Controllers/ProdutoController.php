<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        echo '<h4> Lista de Produtos </h4>';
        echo '<ul>';
        echo '<li> Macarrão </li>';
        echo '<li> Feijão </li>';
        echo '<li> Carne Bovina </li>';
        echo '<li> Arroz </li>';
        echo '<li> Leite </li>';
        echo '</ul>';
    }
}
