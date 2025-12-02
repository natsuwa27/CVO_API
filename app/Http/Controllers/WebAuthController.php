<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

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

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors([
            'error' => 'Correo o contraseña incorrectos',
        ]);
    }

    if (!$user->active) {
        return back()->withErrors([
            'error' => 'Tu cuenta está desactivada. Contacta al administrador.',
        ]);
    }

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
        'error' => 'Correo o contraseña incorrectos',
    ]);
}


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'Sesión cerrada con éxito');
    }

    

    public function adminPanel()
{
    $usuarios = User::all();
    $roles = Role::all();   
    return view('admin.homeadmin', compact('usuarios', 'roles'));

}

public function desactivar($id)
{
    $user = User::findOrFail($id);
    $user->active = 0;
    $user->save();

    return back()->with('success', 'Usuario desactivado correctamente');
}

public function reactivar($id)
{
    $user = User::findOrFail($id);
    $user->active = 1;
    $user->save();

    return back()->with('success', 'Usuario reactivado correctamente');
}

public function showCreateUser()
{
    $roles = Role::all(); 
    return view('admin.crear-usuario', compact('roles'));
}

public function storeUser(Request $request)
{
    $data = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|string|min:4',
        'role_id'  => 'required|exists:roles,id',
        'phone'    => 'nullable|string|max:20',
        'address'  => 'nullable|string|max:255',
        'active'   => 'nullable|boolean',
    ]);

    User::create([
        'name'     => $data['name'],
        'email'    => $data['email'],
        'password' => Hash::make($data['password']),
        'role_id'  => $data['role_id'],
        'phone'    => $data['phone'] ?? null,
        'address'  => $data['address'] ?? null,
        'active'   => isset($data['active']) ? (bool)$data['active'] : true,
    ]);

    return redirect()->route('admin.homeadmin')
        ->with('success', 'Usuario creado correctamente.');
}

public function updateusuario(Request $request, $id)
{
    $user = User::findOrFail($id);

    $data = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email,' . $id,
        'role_id'  => 'required|exists:roles,id',
        'phone'    => 'nullable|string|max:20',
        'address'  => 'nullable|string|max:255',
    ]);

    $user->update($data);

    return redirect()->route('admin.homeadmin')->with('success', 'Usuario actualizado correctamente.');
}


}
