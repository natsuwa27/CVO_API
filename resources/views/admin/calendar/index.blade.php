<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario de Citas - Admin</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Tu CSS (si lo usas en todo el sistema) -->
    <link rel="stylesheet" href="{{ asset('css/EstilosInsanos.css') }}">
</head>
<body>

    <!-- Banner azul superior -->
    <div style="background-color: #007bff; padding: 20px;">
        <h2 class="text-center" style="color: white; margin: 0;">Veterinaria del Oriente</h2>
        <h4 class="text-center" style="color: white; margin: 0; margin-top: 5px;">
            Calendario de Citas (Administrador)
        </h4>
    </div>

    <div class="container mt-4">

        {{-- Mensajes de sesión --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        <h3 class="mb-4 text-center">Calendario mensual</h3>

        <!-- Filtros de año/mes y botón de regenerar -->
        <div class="d-flex flex-wrap align-items-end mb-4">

            <!-- Seleccionar año y mes -->
            <form method="GET" action="{{ route('calendars.index') }}" class="form-inline mr-3 mb-2">
                <div class="form-group mr-2">
                    <label for="year" class="mr-1">Año:</label>
                    <select name="year" id="year" class="form-control">
                        @php $currentYear = now()->year; @endphp
                        @for ($y = $currentYear - 1; $y <= $currentYear + 2; $y++)
                            <option value="{{ $y }}" @selected($y == $year)>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="form-group mr-2">
                    <label for="month" class="mr-1">Mes:</label>
                    <select name="month" id="month" class="form-control">
                        @for ($m = 1; $m <= 12; $m++)
                            @php
                                $monthName = \Carbon\Carbon::create($year, $m, 1)->locale('es')->isoFormat('MMMM');
                            @endphp
                            <option value="{{ $m }}" @selected($m == $month)>
                                {{ ucfirst($monthName) }}
                            </option>
                        @endfor
                    </select>
                </div>

                <button type="submit" class="btn btn-dark">Ver mes</button>
            </form>

            <!-- Generar / Regenerar mes -->
            <form method="POST"
                  action="{{ route('calendars.generateMonth') }}"
                  class="form-inline mb-2"
                  onsubmit="return confirm('¿Seguro que deseas generar / REGENERAR este mes? Esto modificará los días y horarios a partir de hoy.');">
                @csrf
                <input type="hidden" name="year" value="{{ $year }}">
                <input type="hidden" name="month" value="{{ $month }}">
                <button type="submit" class="btn btn-primary">
                    Generar / Regenerar mes
                </button>
            </form>
        </div>

        <!-- Leyenda -->
        <div class="mb-3">
            <span class="badge badge-success">Abierto (día laboral futuro)</span>
            <span class="badge badge-danger">Cerrado</span>
            <span class="badge badge-secondary">Pasado / sin configuración</span>
        </div>

        <!-- Encabezado del mes -->
        <h4>
            {{ ucfirst($startOfMonth->copy()->locale('es')->isoFormat('MMMM')) }} {{ $year }}
        </h4>

        <!-- Cuadrícula del mes -->
        <div class="row border rounded p-2 mt-2">
            @php
                $today          = \Carbon\Carbon::today();
                $firstDayOfWeek = $startOfMonth->dayOfWeekIso; // 1 = lunes
            @endphp

            <!-- Espacios vacíos antes del primer día (para alinear columnas) -->
            @for ($i = 1; $i < $firstDayOfWeek; $i++)
                <div class="col border p-2" style="min-height: 90px;"></div>
            @endfor

            @php
                $date = $startOfMonth->copy();
            @endphp

            @while ($date->lte($endOfMonth))
                @php
                    $dateKey   = $date->format('Y-m-d');
                    $calendar  = $calendars[$dateKey] ?? null;
                    $isPast    = $date->lt($today);
                    $weekdayLabel = ucfirst($date->locale('es')->isoFormat('ddd')); // lun, mar, mié...

                    // Valores por defecto
                    $bgClass = 'bg-light text-muted';
                    $label   = 'Sin configuración';
                    $activeBlocksCount = null;

                    if ($calendar) {
                        // Contar solo bloques activos
                        $activeBlocksCount = $calendar->blocks->where('is_active', true)->count();

                        if (! $calendar->is_open) {
                            $bgClass = 'bg-danger text-white';
                            $label   = 'Cerrado';
                        } else {
                            if ($isPast) {
                                $bgClass = 'bg-light text-muted';
                                $label   = 'Pasado';
                            } else {
                                $bgClass = 'bg-success text-white';
                                $label   = 'Abierto';
                            }
                        }
                    } else {
                        if ($isPast) {
                            $bgClass = 'bg-light text-muted';
                            $label   = 'Pasado';
                        }
                    }
                @endphp

                <div class="col border p-2 {{ $bgClass }}" style="min-height: 90px;">
                    <div class="d-flex justify-content-between">
                        <strong>{{ $weekdayLabel }}</strong>
                        <strong>{{ $date->day }}</strong>
                    </div>

                    @if ($date->isSameDay($today))
                        <span class="badge badge-warning mb-1">Hoy</span>
                    @endif

                    <div>
                        <small>{{ $label }}</small>
                    </div>

                    @if (!is_null($activeBlocksCount))
                        <div>
                            <small>
                                {{ $activeBlocksCount }} horario{{ $activeBlocksCount === 1 ? '' : 's' }}
                                disponible{{ $activeBlocksCount === 1 ? '' : 's' }}
                            </small>
                        </div>
                    @endif

                    @if ($calendar)
                        <div>
                            <a href="{{ route('calendars.show', $calendar) }}"
                               class="{{ str_contains($bgClass, 'bg-light') ? '' : 'text-white' }}">
                                Ver detalle
                            </a>
                        </div>
                    @endif
                </div>

                @php
                    $date->addDay();
                @endphp
            @endwhile
        </div>

    </div> <!-- /.container -->

</body>
</html>