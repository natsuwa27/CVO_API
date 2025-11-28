<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class WebAuthController extends Controller
{
    


    public function showLogin(){
        return view("auth.login");
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            $user = Auth::user();
            switch($user->role_id){
                case 1:
                    return redirect()->route('adminn.homeadmin');
                    break;
                case 2:
                    return redirect()->route("empleado.homeempleado");
                    break;
                case 3:
                    return redirect()->route("cliente.homecliente");
                    break;
                default:
                return redirect()->route("auth.login");
            }
        }else{
            return back()->withErrors([
                "error" => "Las credenciales no coinciden con nuestros registros.",
            ]);
        }
    }

    public function logout(Request $request){
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect("/login");
}
}
