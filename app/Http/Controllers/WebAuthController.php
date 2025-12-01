<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class WebAuthController extends Controller
{
    
    public function webRegister(Request $request)
    {
     
        $request->validate([
            'name'      => 'required|min:3',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:4|confirmed',
        ]);

       User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone'=> $request->phone,
            'address' => $request->address,
            'role_id' => 3, 
        ]);

        return redirect('/login')->with('success', 'Usuario registrado exitosamente.');
    }

    public function profile()
    {
        return view('profile', ['user' => Auth::user()]);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {

            $request->session()->regenerate();
            $user = Auth::user();

            switch ($user->role_id) {
                case 1:
                    return redirect()->route('admin.homeadmin');
                case 2:
                    return redirect()->route('empleado.homeempleado');
                case 3:
                    return redirect()->route('cliente.homecliente');
                default:
                    return redirect()->route('login');
            }
        }

        return back()->withErrors([
            'error' => 'Credenciales incorrectas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
