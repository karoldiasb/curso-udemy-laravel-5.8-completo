@extends('layout.principal')

@section('content')
    <h3>Informações do cliente</h3>

    <p>id: {{ $cliente['id'] }}</p>
    <p>nome: {{ $cliente['nome'] }}</p>

    <br>

    <a href="{{ route('clientes.index') }}">Voltar</a>
@endsection

