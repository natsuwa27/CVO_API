<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Veterinaria del Oriente')</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <style>
    body { background-color: #f8f9fa; }
    nav { background-color: #4289dbff; }
    nav a, nav button { color: #fff !important; }
    .navbar-brand { font-weight: bold; }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg mb-4">
    <div class="container">
      <a class="navbar-brand text-white fw-bold" href="{{ route('cliente.homecliente') }}">
        Veterinaria del Oriente
      </a>

      <div class="ms-auto d-flex gap-2">
        <a href="{{ route('appointments.index') }}" class="btn btn-primary">Mis citas</a>

        <a href="{{ route('appointments.create') }}" class="btn btn-primary">Nueva cita</a>

        <form action="{{ route('logout') }}" method="POST" class="d-inline">
          @csrf
          <button class="btn btn-danger">Cerrar Sesion</button>
        </form>
      </div>
    </div>
  </nav>

  <main class="container">
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
  </main>
</body>
</html>