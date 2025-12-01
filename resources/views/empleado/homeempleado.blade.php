<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/Estilos.css') }}">
    <style>
        .empleado-image {
            max-width: 300px; 
            height: auto;     
            margin-top: 20px; 
            border-radius: 10px;
        }
    </style>
</head>

<body class="d-flex flex-column align-items-center"> 
    <div id="BarraTop">
        <div class="d-flex flex-column align-items-center mt-2">
            <h3 style="color:white">Veterinaria del oriente</h3>
        </div>
    </div>

    <div class="col-10 d-flex flex-column align-items-center mt-2">
        
        <h1 class="mt-4">Bienvenido Empleado</h1>
        
        <img src="{{ asset('css/empleado.jpg') }}" alt="Imagen del Empleado" class="admin-image">
        
    </div>

</body>
</html>
