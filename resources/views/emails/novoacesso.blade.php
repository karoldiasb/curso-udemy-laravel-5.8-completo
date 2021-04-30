
<html>
    <body>
        <h4>Seja bem-vindo(a) {{$nome}}</h4>
        <p>Voce acabou de acessar o sistema utilizando o seu email: {{$email}}</p>
        <p>Data/Hora de acesso: {{$datahora}}</p>

        <div>
            <img width="10%" height="10%" src="{{$message->embed( public_path() . '/img/logo-laravel.png' )}}">
        </div>
    </body>
</html>