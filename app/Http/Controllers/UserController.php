<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function readAll(){
        return response()->json(User::with("role")->get());
    }

    public function create(Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'active' => 'required|boolean',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);
    }

    public function readOne($id){
        return response()->json(User::with("role")->findOrFail($id));
    }

    public function delete($id){
        $user = User::findOrFail($id);
        $user->active = false;
        $user->save();
        return response()->json("message",  "Usuario Desactivado correctamente");
    }

    public function update($id){
        $user = User::findOrFail($id);
        $updatedData = request()->only(['name', 'email', 'role_id', 'phone', 'address','password', 'active']);
        if(!empty($updatedData['password'])){
            $updatedData['password'] = Hash::make($updatedData['password']);
        }else{
            unset($updatedData['password']);
        }
        $user->update($updatedData);
        return response()->json(["message" => "Usuario actualizado correctamente"]);
    }

}
