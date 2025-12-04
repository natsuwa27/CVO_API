@extends('layouts.app')

@section('title', 'Mis citas')

@section('content')
<h2>Mis citas</h2>

<a href="{{ route('appointments.create') }}" class="btn btn-primary mb-3">Nueva cita</a>

<table class="table">
  <thead>
    <tr>
      <th>Mascota</th>
      <th>Servicio</th>
      <th>Horario</th>
      <th>Estado</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    @forelse($appointments as $a)
      <tr>
        <td>{{ $a->pet->name ?? 'N/A' }}</td>
        <td>{{ ucfirst($a->service->name ?? 'N/A') }}</td>
        <td>
          {{ $a->block->calendar->date->format('d/m/Y') }}
          {{ $a->block->start_time }} - {{ $a->block->end_time }}
        </td>
        <td>{{ $a->active ? 'Activa' : 'Cancelada' }}</td>
        <td class="d-flex gap-2">
          <a href="{{ route('appointments.show', $a->id) }}" class="btn btn-info btn-sm">Ver</a>
          <a href="{{ route('appointments.edit', $a->id) }}" class="btn btn-warning btn-sm">Editar</a>
          <form action="{{ route('appointments.delete', $a->id) }}" method="POST" onsubmit="return confirm('¿Cancelar cita?')" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-danger btn-sm">Cancelar</button>
          </form>
        </td>
      </tr>
    @empty
      <tr><td colspan="5" class="text-center">No hay citas registradas.</td></tr>
    @endforelse
  </tbody>
</table>
@endsection