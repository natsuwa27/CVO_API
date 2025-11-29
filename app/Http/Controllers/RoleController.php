<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;


class RoleController extends Controller
{
    public function readAll(){
        return response()->json(Role::with("users")->get());
    }

    public function create(Request $request){
        $data = $request->validate([
            'description' => 'required|string|max:255',
        ]);

        $role = Role::create($data);
        return response()->json(["message" => "Rol creado correctamente", "role" => $role], 201);



    }

    public function readOne($id){
        return response()->json (Role::with ("users")->findOrFail($id));
    }

    public function update($id){
        $role = Role::findOrFail($id);
        $updateData = request()->only(['description']);
        $role->update($updateData);
        return response()->json (["message" => "Rol actualizado correctamente", "role" => $role]);
    }
    
}
