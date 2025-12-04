<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del día</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div style="background-color: #4289dbff; padding: 15px;">
        <h3 class="text-center text-white m-0">Veterinaria del Oriente</h3>
        <h5 class="text-center text-white m-0">Calendario de Citas - Detalle del Día</h5>
    </div>
    <div class="container mt-4">
        <a href="{{ route('calendars.index', ['year' => $calendar->date->year, 'month' => $calendar->date->month]) }}"
           class="btn btn-secondary mb-3">
            ← Regresar al calendario
        </a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <h2>Día: {{ $calendar->date->format('j \d\e F Y') }}</h2>

        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Fecha:</strong> {{ $calendar->date->format('Y-m-d') }}</p>

                <p>
                    <strong>Estado del día:</strong>
                    @if ($calendar->is_open)
                        <span class="badge badge-success">Abierto</span>
                    @else
                        <span class="badge badge-danger">Cerrado</span>
                    @endif
                </p>

                <p><strong>Horario del día:</strong> {{ $calendar->start_time }} — {{ $calendar->end_time }}</p>

                {{-- BOTÓN CERRAR / REABRIR --}}
                @php
                    $today = \Carbon\Carbon::today();
                    $weekday = $calendar->date->dayOfWeekIso; // 1 = lun ... 7 = dom
                @endphp

                @if ($calendar->date->gte($today) && $weekday <= 5)
                    <form action="{{ route('calendars.closeDay', $calendar) }}"
                          method="POST"
                          class="mt-2"
                          onsubmit="return confirm('¿Seguro que deseas {{ $calendar->is_open ? 'CERRAR' : 'REABRIR' }} este día completo?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="btn {{ $calendar->is_open ? 'btn-danger' : 'btn-success' }}">
                            {{ $calendar->is_open ? 'Cerrar todo el día' : 'Reabrir día' }}
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <h3>Bloques de horario</h3>

        <table class="table table-bordered table-striped mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>Hora inicio</th>
                    <th>Hora fin</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($calendar->blocks as $block)
                    <tr>
                        <td>{{ $block->start_time }}</td>
                        <td>{{ $block->end_time }}</td>
                        <td>
                            @if(!$block->is_active)
                                <span class="badge badge-secondary">Inactivo</span>
                            @elseif($block->is_booked)
                                <span class="badge badge-danger">Ocupado</span>
                            @else
                                <span class="badge badge-success">Libre</span>
                            @endif
                        </td>
                        <td>
                            @if ($calendar->is_open)
                                @if(!$block->is_booked)
                                    <form action="{{ route('blocks.toggle', $block) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Seguro que deseas cambiar la disponibilidad de este bloque?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="btn btn-sm {{ $block->is_active ? 'btn-danger' : 'btn-success' }}">
                                            {{ $block->is_active ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                @else
                                    <em>Bloque ocupado (no modificable)</em>
                                @endif
                            @else
                                <em>No disponible (día cerrado)</em>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No hay bloques generados para este día.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>