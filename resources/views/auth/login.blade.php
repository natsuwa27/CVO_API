<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    {{-- CSS desde /public/css --}}
    <link rel="stylesheet" href="{{ asset('css/Estilos.css') }}">
</head>

<body class="d-flex flex-column align-items-center">

    <div id="BarraTop">
        <div class="d-flex flex-column align-items-center mt-2">
            <h3 style="color:white;">Veterinaria del oriente</h3>
        </div>
    </div>

    <div class="col-10 d-flex justify-content-center mt-2">
        <div class="container d-flex justify-content-center mt-5"
            style="background-color: var(--color-contenedor); border-radius: 5px; height: 300px; width: 400px; padding: 20px;">

            <form method="POST" action="{{ route('login.post') }}" class="col-10">
                @csrf

                <label>Email</label>
                <input type="email" name="email" class="input-form" placeholder="...@gmail.com" required>

                <label>Contraseña</label>
                <input type="password" name="password" class="input-form" placeholder="********" required>

                <div id="ContenedorRegistro">
                    <button type="submit">Iniciar Sesión</button>
                </div>
            </form>

        </div>
    </div>

</body>
</html>
