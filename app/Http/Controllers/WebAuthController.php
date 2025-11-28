<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                    return redirect()->route("admin.inicio");
                    break;
                case 2:
                    return redirect()->route("trabajador.inicio");
                    break;
                case 3:
                    return redirect()->route("cliente.inicio");
                    break;
                default:
                return redirect()->route("login");
            }
        }else{
            return back()->withErrors([
                "error" => "Las credenciales no coinciden con nuestros registros.",
            ]);
        }
    }

    public function logout(Request $request){
        Auth::guard('web')->logout();
        return redirect("/login");
    }
}
