@extends('layouts.app')

@section('title', 'Registrar mascota')

@section('content')
<h2 class="mb-4">Registrar nueva mascota</h2>

<form action="{{ route('pets.store') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
  @csrf

  <div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="name" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Especie</label>
    <input type="text" name="species" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Raza</label>
    <input type="text" name="breed" class="form-control">
  </div>

  <div class="mb-3">
    <label class="form-label">Color</label>
    <input type="text" name="color" class="form-control">
  </div>

  <div class="mb-3">
    <label class="form-label">Señas particulares</label>
    <input type="text" name="special_marks" class="form-control">
  </div>

  <div class="mb-3">
    <label class="form-label">Peso (kg)</label>
    <input type="number" step="0.1" name="weight" class="form-control">
  </div>

  <div class="mb-3">
    <label class="form-label">Sexo</label>
    <select name="sex" class="form-select" required>
      <option value="male">Macho</option>
      <option value="female">Hembra</option>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Edad (años)</label>
    <input type="number" name="age" class="form-control">
  </div>

  <div class="mb-3">
    <label class="form-label">Foto</label>
    <input type="file" name="photo" class="form-control">
  </div>

  <button class="btn btn-primary w-100">Guardar mascota</button>
  
</form>
@endsection