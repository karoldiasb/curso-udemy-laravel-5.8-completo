@extends('layout.principal')

@section('content')
    <h3>{{$titulo}}</h3>

    <a href="{{ route('clientes.create') }}">Criar novo</a>

    @if(count($clientes) > 0 )

        <ul>
            @foreach ($clientes as $cliente)
                <li>
                    {{ $cliente['id'] }} | {{ $cliente['nome'] }}
                    <a href="{{ route('clientes.edit', $cliente['id']) }} ">Editar</a>
                    <a href="{{ route('clientes.show', $cliente['id']) }} ">Info</a>

                    <form action="{{ route('clientes.destroy', $cliente['id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Apagar">
                    </form>
                </li>
            @endforeach
        </ul>

    {{--  @else
        <h4> Não existem usuários cadastrados. Adicione um usuário. </h4>  --}}
    @endif

    @empty($clientes)
        <h4> Não existem usuários cadastrados. Adicione um usuário. </h4>
    @endempty

@endsection