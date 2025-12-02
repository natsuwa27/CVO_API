<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'CVO')</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
  <nav class="mb-3 d-flex gap-2 align-items-center">
    <a href="{{ route('appointments.index') }}" class="btn btn-link">Mis citas</a>
    <a href="{{ route('appointments.create') }}" class="btn btn-primary">Nueva cita</a>
    <form action="/logout" method="POST" class="d-inline">
      @csrf
      <button class="btn btn-outline-danger">Salir</button>
    </form>
  </nav>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @yield('content')
</body>
</html>