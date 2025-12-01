<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Mascotas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Tus estilos -->
</head>
<body>
    <div class="container">
        <h1>Bienvenido [Usuario]</h1>
        <img src="banner.jpg" alt="Banner mascotas"> <!-- Adapta a tu imagen -->
        <h2>Mis mascotas</h2>
        <p>Pulsa el perfil de tu mascota para ver su información</p>
        <div class="row">
            <div class="col">
                <a href="{{ route('pets.create') }}">
                    <img src="huella.png" alt="Agregar mascota"> <!-- Icono + -->
                    <p>Agregar mascota</p>
                </a>
            </div>
            @foreach($pets as $pet)
                <div class="col">
                    <a href="{{ route('pets.show', $pet->id) }}">
                        @if($pet->photo_path)
                            <img src="{{ asset('storage/' . $pet->photo_path) }}" alt="{{ $pet->name }}" class="rounded-circle">
                        @else
                            <img src="default_pet.png" alt="Default">
                        @endif
                        <p>{{ $pet->name }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>