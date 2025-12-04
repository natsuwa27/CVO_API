@extends('layouts.app')

@section('title', 'Detalle de cita')

@section('content')
<h2>Detalle de cita</h2>

<ul class="list-group mb-3">
  <li class="list-group-item">
    <strong>Mascota:</strong> {{ $appointment->pet->name ?? 'N/A' }}
  </li>
  <li class="list-group-item">
    <strong>Servicio:</strong> {{ ucfirst($appointment->service->name ?? 'N/A') }}
  </li>
  <li class="list-group-item">
    <strong>Horario:</strong>
    {{ $appointment->block->calendar->date->format('d/m/Y') }}
    {{ $appointment->block->start_time }} - {{ $appointment->block->end_time }}
  </li>
  <li class="list-group-item">
    <strong>Motivo:</strong> {{ $appointment->reason }}
  </li>
  <li class="list-group-item">
    <strong>Estado:</strong>
    @if($appointment->active)
      <span class="badge bg-success">Activa</span>
    @else
      <span class="badge bg-danger">Cancelada por cierre de día</span>
    @endif
  </li>
</ul>

<div class="d-flex gap-2">
  <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Volver</a>

  @if($appointment->active)
    <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-warning">Editar</a>
    <form action="{{ route('appointments.delete', $appointment->id) }}" method="POST"
          onsubmit="return confirm('¿Cancelar cita?')" class="d-inline">
      @csrf
      @method('DELETE')
      <button class="btn btn-danger">Cancelar</button>
    </form>
  @else
    <span class="text-muted">Esta cita fue cancelada por el administrador.</span>
  @endif
</div>
@endsection