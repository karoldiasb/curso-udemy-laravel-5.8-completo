<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Hash;
class AdminLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin'); //só entra se for convidado = se não estiver logado como admin
    }

    public function login(Request $request)
    {
        // dd(Hash::make('adm123'));exit; = $2y$10$XsxS2ykfB8jAmyj0mD/UnuU6k76M5VHiWCJpw7Z2iCcB9ZEHoVFG.
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $authOK = Auth::guard('admin')->attempt($credentials, $request->remember);

        // dd($authOK);
        if($authOK){
            return redirect()->intended(route('admin.dashboard'));
        }
        return redirect()->back()->withInputs($request->only('email', 'remember'));
    }

    public function index()
    {
        return view('auth.admin-login');
    }
}
