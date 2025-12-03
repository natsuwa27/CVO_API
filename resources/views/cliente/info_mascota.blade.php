@extends('layouts.app')

@section('title', 'Detalle de mascota')

@section('content')
<h2 class="mb-4">Detalle de mascota</h2>

<div class="card p-4 shadow-sm">
  <h5>{{ $pet->name }}</h5>
  <p><strong>Especie:</strong> {{ $pet->species }}</p>
  <p><strong>Raza:</strong> {{ $pet->breed ?? 'N/A' }}</p>
  <p><strong>Color:</strong> {{ $pet->color ?? 'N/A' }}</p>
  <p><strong>Señas particulares:</strong> {{ $pet->special_marks ?? 'N/A' }}</p>
  <p><strong>Peso:</strong> {{ $pet->weight ?? 'N/A' }} kg</p>
  <p><strong>Sexo:</strong> {{ $pet->sex == 'male' ? 'Macho' : 'Hembra' }}</p>
  <p><strong>Edad:</strong> {{ $pet->age ?? 'N/A' }} años</p>

  @if($pet->photo_path)
    <div class="mt-3">
      <img src="{{ asset('storage/' . $pet->photo_path) }}" alt="Foto de {{ $pet->name }}" class="img-thumbnail" width="200">
    </div>
  @endif

  <div class="mt-3 d-flex gap-2">
    <a href="{{ route('pets.edit', $pet->id) }}" class="btn btn-outline-primary">Editar</a>
    <form action="{{ route('pets.destroy', $pet->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta mascota?')">
      @csrf @method('DELETE')
      <button class="btn btn-outline-danger">Eliminar</button>
      
    </form>
  </div>
</div>
@endsection