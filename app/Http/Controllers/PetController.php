<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    // Lista de mascotas (vista homecliente)
    public function index()
    {
        $pets = Pet::where('owner_id', Auth::id())->get();
        return view('cliente.homecliente', compact('pets'));
    }

    // Formulario para agregar
    public function create()
    {
        return view('cliente.registro_mascota');
    }

    // Guardar nueva mascota
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'species' => 'required|string',
            'breed' => 'nullable|string',
            'color' => 'nullable|string',
            'special_marks' => 'nullable|string',
            'weight' => 'nullable|numeric',
            'sex' => 'required|in:male,female',
            'age' => 'nullable|integer',
            'photo' => 'nullable|image|mimes:jpeg,png|max:5000', // Max 5MB
            'active'   => 'nullable|boolean'

        ]);

        $data['owner_id'] = Auth::id();

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('pets', 'public');
        }

        Pet::create($data);

        return redirect()->route('cliente.homecliente')->with('success', 'Mascota registrada exitosamente.');
    }

    // Ver detalle de mascota
    public function show($id)
    {
        $pet = Pet::findOrFail($id);
        if ($pet->owner_id !== Auth::id()) {
            abort(403);
        }
        return view('cliente.info_mascota', compact('pet'));
    }

    // Formulario editar
    public function edit($id)
    {
        $pet = Pet::findOrFail($id);
        if ($pet->owner_id !== Auth::id()) {
            abort(403);
        }
        return view('cliente.editar_mascota', compact('pet'));
    }

    // Actualizar mascota
    public function update(Request $request, $id)
    {
        $pet = Pet::findOrFail($id);
        if ($pet->owner_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string',
            'species' => 'required|string',
            'breed' => 'nullable|string',
            'color' => 'nullable|string',
            'special_marks' => 'nullable|string',
            'weight' => 'nullable|numeric',
            'sex' => 'required|in:male,female',
            'age' => 'nullable|integer',
            'photo' => 'nullable|image|mimes:jpeg,png|max:5000',
            'active'   => 'nullable|boolean'
        ]);

        if ($request->hasFile('photo')) {
            
            if ($pet->photo_path) {
                Storage::delete('public/' . $pet->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('pets', 'public');
        }

        $pet->update($data);

        return redirect()->route('pets.show', $id)->with('success', 'Mascota actualizada exitosamente.');
    }

    // Borrar mascota
    public function destroy($id)
    {
        $pet = Pet::findOrFail($id);
        if ($pet->owner_id !== Auth::id()) {
            abort(403);
        }

        if ($pet->photo_path) {
            Storage::delete('public/' . $pet->photo_path);
        }

        $pet->delete();

        return redirect()->route('cliente.homecliente')->with('success', 'Mascota borrada exitosamente.');
    }

    // API para móvil
    public function apiIndex()
    {
        $pets = Pet::where('owner_id', Auth::id())->get();
        return response()->json($pets);
    }
}
