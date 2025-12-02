@extends('layouts.app')

@section('title', 'Editar cita')

@section('content')
<h2>Editar cita</h2>

<form action="{{ route('appointments.update', $appointment->id) }}" method="POST" class="mt-3">
  @csrf @method('PUT')

  <div class="mb-3">
    <label class="form-label">Mascota</label>
    <select name="pet_id" class="form-select">
      @foreach($pets as $pet)
        <option value="{{ $pet->id }}" @selected($appointment->pet_id == $pet->id)>{{ $pet->name }}</option>
      @endforeach
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Servicio</label>
    <select name="service_id" class="form-select">
      @foreach($services as $service)
        <option value="{{ $service->id }}" @selected($appointment->service_id == $service->id)>{{ ucfirst($service->name) }}</option>
      @endforeach
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Fecha y hora</label>
    <input type="datetime-local" name="date" class="form-control" value="{{ \Carbon\Carbon::parse($appointment->date)->format('Y-m-d\TH:i') }}">
  </div>

  <div class="mb-3">
    <label class="form-label">Motivo</label>
    <input type="text" name="reason" class="form-control" value="{{ $appointment->reason }}">
  </div>

  <button class="btn btn-warning">Actualizar</button>
</form>
@endsection