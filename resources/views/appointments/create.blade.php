@extends('layouts.app')

@section('title', 'Nueva cita')

@section('content')
<h2>Nueva cita</h2>

@if($pets->isEmpty())
  <div class="alert alert-warning">
    No tienes mascotas registradas, registra una mascota primero para poder crear una cita.
  </div>
@else
  <form action="{{ route('appointments.store') }}" method="POST" class="mt-3">
    @csrf
    <div class="mb-3">
      <label class="form-label">Mascota</label>
      <select name="pet_id" class="form-select" required>
        @foreach($pets as $pet)
          <option value="{{ $pet->id }}">{{ $pet->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Servicio</label>
      <select name="service_id" class="form-select" required>
        @foreach($services as $service)
          <option value="{{ $service->id }}">{{ ucfirst($service->name) }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Fecha y hora</label>
      <select name="block_id" class="form-select" required>
        @foreach($blocks as $block)
          <option value="{{ $block->id }}">
            {{ $block->calendar->date->format('d/m/Y') }}
            ({{ $block->calendar->date->locale('es')->isoFormat('dddd') }})
            {{ $block->start_time }} - {{ $block->end_time }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Motivo</label>
      <input type="text" name="reason" class="form-control" maxlength="255" required>
    </div>

    <button class="btn btn-primary">Guardar cita</button>
  </form>
@endif
@endsection