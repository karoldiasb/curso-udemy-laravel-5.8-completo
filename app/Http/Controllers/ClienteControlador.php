<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ClienteControlador extends Controller
{
    private $clientes = [
        ['id' => 1, 'nome' => 'ademir'],
        ['id' => 2, 'nome' => 'joao'],
        ['id' => 3, 'nome' => 'maria'],
        ['id' => 4, 'nome' => 'aline']
    ];

    public function __construct()
    {
        $clientes = session('clientes');
        if(!isset($clientes))
            session(['clientes' => $this->clientes]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = session('clientes');
        $titulo = "Todos os clientes";
        return view('clientes.index', compact(['clientes', 'titulo']));
        
        // outros exemplos:
        // return view('clientes.index')
        //     ->with('clientes', $clientes)
        //     ->with('titulo', $titulo);
        
        // return view('clientes.index',
        //     ['clientes' => $clientes, 'titulo' => $titulo]
        // );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clientes = session('clientes');
        $id = end($clientes)['id'] + 1;
        $parametros = [
            'id' => $id,
            'nome' => $request->nome
        ];

        $clientes[] = $parametros;

        session(['clientes' => $clientes]);

        return redirect()->route('clientes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) // = detalhar
    {
        $clientes = session('clientes');
        $index = $this->getIndex($id, $clientes);
        $cliente = $clientes[$index];

        return view('clientes.info', compact(['cliente']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clientes = session('clientes');
        $index = $this->getIndex($id, $clientes);
        $cliente = $clientes[$index];

        return view('clientes.edit', compact(['cliente']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $clientes = session('clientes');
        $index = $this->getIndex($id, $clientes);

        $clientes[$index]['nome'] = $request->nome;
        
        session(['clientes' => $clientes]);

        return redirect()->route('clientes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $clientes = session('clientes');
        $index = $this->getIndex($id, $clientes);
        array_splice($clientes, $index, 1);

        session(['clientes' => $clientes]);

        return redirect()->route('clientes.index');

    }

    private function getIndex($id, $clientes)
    {
        $ids = array_column($clientes, 'id');
        $index = array_search($id, $ids);

        return $index;
    }
}
