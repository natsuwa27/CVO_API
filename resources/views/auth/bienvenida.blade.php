<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Veterinaria del Oriente</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        :root {
            --primary-color: #007bff; /* Azul vibrante */
            --navbar-color: #3f98ff; /* Azul claro */
            --bg-overlay: rgba(0, 0, 0, 0.5); /* Overlay oscuro para contraste */
            --card-bg: rgba(255, 255, 255, 0.95); /* Fondo de tarjeta semitransparente */
            --button-primary: #007bff;
            --button-secondary: #28a745; /* Verde para Registrarse */
        }

        body {
            font-family: 'Poppins', sans-serif;
            /* Usamos la imagen de fondo con un overlay oscuro */
            background-image: linear-gradient(var(--bg-overlay), var(--bg-overlay)), url('{{ asset('css/Mascotasfondo.jpg') }}');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white; /* Texto principal en blanco sobre el fondo oscuro */
        }

        /* Encabezado fijo (simulación de la barra superior) */
        #BarraTop {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: var(--navbar-color);
            padding: 15px 0;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        #BarraTop h3 {
            color: white;
            font-weight: 600;
            margin: 0;
        }

        /* Contenedor principal del mensaje */
        .welcome-card {
            background-color: var(--card-bg);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            padding: 40px;
            width: 90%;
            max-width: 600px;
            margin-top: 80px; /* Separación del encabezado fijo */
            text-align: center;
            color: #333; /* Texto dentro de la tarjeta oscuro */
        }
        
        .welcome-card h1 {
            font-weight: 700;
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .welcome-card h4 {
            font-weight: 400;
            margin-bottom: 30px;
        }

        /* Estilo de los botones */
        .welcome-card button {
            padding: 12px 25px;
            margin: 10px;
            border: none;
            border-radius: 8px;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            min-width: 180px;
        }
        
        /* Botón Iniciar Sesión */
        .btn-login {
            background-color: var(--button-primary);
            color: white;
        }
        .btn-login:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        /* Botón Registrarse */
        .btn-register {
            background-color: var(--button-secondary);
            color: white;
        }
        .btn-register:hover {
            background-color: #1e7e34;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

    </style>
</head>

<body>

    <div id="BarraTop">
        <div class="container text-center">
            <h3>Veterinaria del Oriente</h3>
        </div>
    </div>

    <div class="welcome-card">

        <img src="{{ asset('css/logo.jpg') }}" width="80" class="rounded-circle mb-3 border border-primary p-1" alt="Logo">

        <h1 class="mb-2">¡Te damos la bienvenida!</h1>
        <h4 class="mb-4">Tu aliado para el cuidado de tus mascotas.</h4>

        <p class="lead text-muted mb-4">
            Regístrate para agendar citas, ver historiales y tener el control del bienestar de tus compañeros.
        </p>

        <div class="d-flex flex-column flex-md-row justify-content-center mt-4">
            <button class="btn-register" onclick="window.location.href='{{ route('registro') }}'">
                <i class="fas fa-user-plus mr-2"></i> Registrarse
            </button>
            <button class="btn-login" onclick="window.location.href='{{ route('login') }}'">
                <i class="fas fa-sign-in-alt mr-2"></i> Iniciar Sesión
            </button>
        </div>

    </div>

</body>
</html>
