<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

use Illuminate\Support\Facades\Cache;

class ProdutosController extends Controller
{
    public function index()
    {
        $expiracao = 1; //1 minutos

        $produtos = Cache::remember('todosprodutos', $expiracao, function(){
            return Produto::with('categorias')->get();
        });
         
        return view('produtos', compact(['produtos']));
    }
}
