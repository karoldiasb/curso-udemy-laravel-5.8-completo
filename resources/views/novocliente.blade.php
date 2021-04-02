<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>Document</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <style>
        body{
            padding: 20px;
        }
    </style>
</head>
<body>

    <main role="main">
        <div class="row">
            <div class="container col-sm-8 offset-md-2">
                <div class="card border">
                    <div class="card-header">
                        <div class="card-title"> <h2> Cadastro de Cliente </h2> </div>
                    </div>
                    <div class="card-body">
                        <form action="/cliente" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nome"> Nome do Cliente </label>
                                <input type="text" name="nome" class="form-control {{ $errors->has('nome') ? 'is-invalid' : '' }}" id="nome" placeholder="Nome do Cliente">
                                
                                @if ($errors->has('nome'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('nome') }}
                                    </div>
                                @endif
                                
                            </div>
                            <div class="form-group">
                                <label for="idade"> Idade do Cliente </label>
                                <input type="text" name="idade" class="form-control {{ $errors->has('idade') ? 'is-invalid' : '' }}" id=" idade"placeholder="Idade do Cliente">

                                @if ($errors->has('idade'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('idade') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="endereco"> Endereço do Cliente </label>
                                <input type="text" name="endereco" class="form-control {{ $errors->has('endereco') ? 'is-invalid' : '' }}" id="endereco" placeholder="Endereço do Cliente">

                                @if ($errors->has('endereco'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('endereco') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email"> E-mail do Cliente </label>
                                <input type="text" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" placeholder="E-mail do Cliente">
                                @if ($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                            <button type="cancel" class="btn btn-danger btn-sm">Cancelar</button>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </main>

    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>