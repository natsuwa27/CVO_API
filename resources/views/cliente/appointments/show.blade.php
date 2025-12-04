@extends('layouts.app')

@section('title', 'Detalle de cita')

@section('content')
<h2>Detalle de cita</h2>
<ul class="list-group">
  <li class="list-group-item"><strong>Mascota:</strong> {{ $appointment->pet->name ?? 'N/A' }}</li>
  <li class="list-group-item"><strong>Servicio:</strong> {{ ucfirst($appointment->service->name ?? 'N/A') }}</li>
  <li class="list-group-item">
    <strong>Horario:</strong>
    {{ $appointment->block->calendar->date->format('d/m/Y') }}
    {{ $appointment->block->start_time }} - {{ $appointment->block->end_time }}
  </li>
  <li class="list-group-item"><strong>Motivo:</strong> {{ $appointment->reason }}</li>
  <li class="list-group-item"><strong>Estado:</strong> {{ $appointment->active ? 'Activa' : 'Cancelada' }}</li>
</ul>
@endsection