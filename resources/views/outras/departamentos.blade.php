@extends('layout.principal')

@section('content')
    <h3>Departamentos</h3>

    <ul>
        <li>Computadores</li>
        <li>Eletrônicos</li>
        <li>Acessórios</li>
        <li>Roupas</li>
    </ul>

    <x-alerta titulo="Error" tipo="error">
        <p><strong>Erro inesperado</strong></p>
        <p>Ocorreu um erro inesperado</p>
    </x-alerta>
   

@endsection
