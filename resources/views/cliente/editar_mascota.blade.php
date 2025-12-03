@extends('layouts.app')

@section('title', 'Editar mascota')

@section('content')
<h2 class="mb-4">Editar mascota</h2>

<form action="{{ route('pets.update', $pet->id) }}" method="POST" class="card p-4 shadow-sm">
  @csrf @method('PUT')

  <div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="name" class="form-control" value="{{ $pet->name }}" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Especie</label>
    <input type="text" name="species" class="form-control" value="{{ $pet->species }}" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Raza</label>
    <input type="text" name="breed" class="form-control" value="{{ $pet->breed }}">
  </div>

  <div class="mb-3">
    <label class="form-label">Color</label>
    <input type="text" name="color" class="form-control" value="{{ $pet->color }}">
  </div>

  <div class="mb-3">
    <label class="form-label">Señas particulares</label>
    <input type="text" name="special_marks" class="form-control" value="{{ $pet->special_marks }}">
  </div>

  <div class="mb-3">
    <label class="form-label">Peso (kg)</label>
    <input type="number" step="0.1" name="weight" class="form-control" value="{{ $pet->weight }}">
  </div>

  <div class="mb-3">
    <label class="form-label">Sexo</label>
    <select name="sex" class="form-select" required>
      <option value="male" @selected($pet->sex == 'male')>Macho</option>
      <option value="female" @selected($pet->sex == 'female')>Hembra</option>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Edad (años)</label>
    <input type="number" name="age" class="form-control" value="{{ $pet->age }}">
  </div>

  <button class="btn btn-warning w-100">Actualizar mascota</button>
  
</form>
@endsection