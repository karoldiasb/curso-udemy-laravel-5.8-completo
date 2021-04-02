@extends('layout.app', [ "current" => "categorias" ]);


@section('body')
    <div class="card border">
        <div class="card-body">
            <form action="/categorias/{{$categoria->id}}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="nomeCategoria">Nome da Categoria</label>
                    <input
                        type="text"
                        name="nomeCategoria"
                        id="nomeCategoria"
                        class="form-control"
                        placeholder="Insira a categoria"
                        value="{{$categoria->nome}}"
                    >
                </div>

                <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
            </form>
        </div>
    </div>
@stop
