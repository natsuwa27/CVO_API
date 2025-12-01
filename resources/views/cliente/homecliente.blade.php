<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Mascotas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Agrega tus estilos personalizados aquí, e.g., asset('css/Estilos.css') -->
    <link rel="stylesheet" href="{{ asset('css/Estilos.css') }}">
</head>
<body>
    <nav class="navbar navbar-light bg-info">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('images/logo_paw.png') }}" alt="Logo" width="30" height="30" class="d-inline-block align-top"> <!-- Asume logo_paw.png en public/images -->
        </a>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
            <li class="nav-item active"><a class="nav-link" href="#">Mis mascotas</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Agendar una cita</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Mas sobre nosotros</a></li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-bell"></i></a></li> <!-- Asume Font Awesome para icons -->
            <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-user"></i></a></li>
        </ul>
    </nav>

    <div class="container-fluid">
        <h1>Bienvenido {{ Auth::user()->name }}:</h1> <!-- Usa el nombre del usuario autenticado -->
        
        <!-- Banner con imágenes de animales -->
        <div class="banner" style="position: relative; height: 200px; background-color: #ffffff;"> <!-- Ajusta altura y estilos -->
            <img src="{{ asset('images/shiba_inu.jpg') }}" alt="Shiba Inu" style="position: absolute; left: 10%; top: 20%; height: 150px;"> <!-- Asume nombres de imágenes basados en screenshot -->
            <img src="{{ asset('images/parrot.jpg') }}" alt="Parrot" style="position: absolute; left: 25%; top: 40%; height: 100px;">
            <img src="{{ asset('images/clinic_logo.png') }}" alt="Veterinaria del Oriente" style="position: absolute; left: 35%; top: 30%; height: 120px;"> <!-- Logo central -->
            <img src="{{ asset('images/bernese.jpg') }}" alt="Bernese" style="position: absolute; left: 50%; top: 20%; height: 150px;">
            <img src="{{ asset('images/cat.jpg') }}" alt="Cat" style="position: absolute; left: 65%; top: 50%; height: 100px;">
            <img src="{{ asset('images/panda.jpg') }}" alt="Panda" style="position: absolute; left: 70%; top: 40%; height: 120px;"> <!-- Ajusta posiciones para matching -->
            <img src="{{ asset('images/chihuahua.jpg') }}" alt="Chihuahua" style="position: absolute; left: 80%; top: 30%; height: 100px;">
        </div>

        <div class="bg-info mt-3 p-2"></div> <!-- Línea azul separadora -->

        <h2>Mis mascotas</h2>
        <p>Pulsa el perfil de tu mascota para ver su información</p>

        <div class="d-flex justify-content-start flex-wrap">
            <!-- Botón agregar mascota -->
            <div class="text-center m-3">
                <a href="{{ route('pets.create') }}">
                    <img src="{{ asset('images/paw_add.png') }}" alt="Agregar mascota" class="rounded-circle" style="width: 100px; height: 100px;"> <!-- Asume paw_add.png con + -->
                    <p>Agregar mascota</p>
                </a>
            </div>

            <!-- Lista de mascotas dinámicas -->
            @foreach($pets as $pet)
                <div class="text-center m-3">
                    <a href="{{ route('pets.show', $pet->id) }}">
                        @if($pet->photo_path)
                            <img src="{{ asset('storage/' . $pet->photo_path) }}" alt="{{ $pet->name }}" class="rounded-circle" style="width: 100px; height: 100px;">
                        @else
                            <img src="{{ asset('images/default_pet.png') }}" alt="Default" class="rounded-circle" style="width: 100px; height: 100px;">
                        @endif
                        <p>{{ $pet->name }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Incluye Font Awesome si usas icons -->
    <script src="https://kit.fontawesome.com/yourkit.js" crossorigin="anonymous"></script>
</body>
</html>