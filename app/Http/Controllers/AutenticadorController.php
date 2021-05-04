<?php

namespace App\Http\Controllers;

use App\Events\EventNovoRegistro;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AutenticadorController extends Controller
{
    public function registro(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->token = Str::random(60);

        $user->save();

        event(new EventNovoRegistro($user));

        return response()->json([
            'res' => 'usuario criado com sucesso'
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credenciais = [
            'email' => $request->email,
            'password' => $request->password,
            'active' => 1
        ];
        
        if(!Auth::attempt($credenciais)){
            return response()->json([
                'res' => 'acesso negado'
            ], 401);
        }

        $user = $request->user();
        $token = $user->createToken('Token de acesso')->accessToken;

        return response()->json([
            'token' => $token
        ], 200);
        
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke(); //revoga o token => usuário perde o token
        
        return response()->json([
            'res' => 'deslogado com sucesso'
        ], 200);
    }

    public function ativarregistro($id, $token)
    {
        $user = User::find($id);

        if($user){
            if($user->token == $token){
                $user->active = true;
                $user->token = '';
                $user->save();

                return view('registroativo');
            }
        }
        return view('registroerro');
    }
}
