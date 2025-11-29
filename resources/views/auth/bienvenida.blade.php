<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/Estilos.css') }}">
</head>

<body style="background-image: url('{{ asset('css/Mascotasfondo.jpg') }}');"
      class="d-flex flex-column align-items-center">

    <div id="BarraTop">
        <div class="d-flex flex-column align-items-center mt-2">
            <h3 style="color:white;">Veterinaria del oriente</h3>
        </div>
    </div>

    <div class="col-10 d-flex justify-content-center mt-4">
        <div class="container d-flex justify-content-center mt-5"
             style="background-color: var(--color-contenedor); border-radius:5px; height:450px; width:800px; padding:20px; border:2px solid #0000003b;">

            <div class="col-10 text-center">
                <h1 style="margin:75px;">¡Te damos la bienvenida!</h1>
                <h4>Veterinaria del oriente</h4>

                <button onclick="window.location.href='{{ route('registro') }}'">Registrarse</button>
                <button onclick="window.location.href='{{ route('login') }}'">Iniciar Sesión</button>
            </div>

        </div>
    </div>

</body>
</html>
