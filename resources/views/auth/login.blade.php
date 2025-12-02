<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Veterinaria del Oriente</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        :root {
            --primary-color: #007bff; /* Azul vibrante */
            --navbar-color: #3f98ff; /* Azul claro */
            --bg-light: #f4f9ff;
            --card-bg: white;
            --button-color: #007bff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(244, 249, 255, 0.95), rgba(244, 249, 255, 0.95)), url('{{ asset("css/pattern-bg.jpg") }}') center/cover;
            /* Usar un patrón de fondo o una imagen suave */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center; /* Centrar todo el contenido verticalmente */
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
        
        /* Contenedor principal del formulario */
        .login-container {
            background-color: var(--card-bg);
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15); /* Sombra más definida */
            padding: 30px;
            width: 100%;
            max-width: 420px;
            margin-top: 80px; /* Separación del encabezado fijo */
        }

        /* Estilos de inputs y labels */
        label {
            display: block;
            font-weight: 500;
            margin-top: 15px;
            color: #333;
        }

        .input-form {
            width: 100%;
            padding: 10px 15px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .input-form:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            outline: none;
        }

        /* Botón de Submit */
        #ContenedorRegistro button[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-top: 25px;
            background-color: var(--button-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }
        #ContenedorRegistro button[type="submit"]:hover {
            background-color: #0056b3;
            transform: translateY(-1px);
        }
        
        /* Estilos para mensajes de error */
        .alert-danger {
            border-radius: 8px;
            font-size: 0.95rem;
            margin-bottom: 20px;
        }

    </style>
</head>

<body>

    <div id="BarraTop">
        <div class="container text-center">
            <h3>Veterinaria del Oriente</h3>
        </div>
    </div>

    <div class="login-container">
        
        <div class="text-center mb-4">
            <img src="{{ asset('css/logo.jpg') }}" width="60" class="rounded-circle mb-3" alt="Logo">
            <h4 class="font-weight-bold text-primary">Acceso al Sistema</h4>
            <p class="text-muted small">Ingresa tus credenciales</p>
        </div>

        <form method="POST" action="{{ route('login.post') }}" class="col-12 p-0">
            @csrf

            {{-- ------------------- MENSAJES DE ERROR ------------------- --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Error si email o contraseña están mal (general) --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                </div>
            @endif
            {{-- ---------------------------------------------------------- --}}

            <label for="email"><i class="fas fa-user-circle mr-2"></i> Email</label>
            <input type="email" id="email" name="email" class="input-form" placeholder="ejemplo@veterinaria.com" required value="{{ old('email') }}">

            <label for="password"><i class="fas fa-lock mr-2"></i> Contraseña</label>
            <input type="password" id="password" name="password" class="input-form" placeholder="********" required>

            <div id="ContenedorRegistro">
                <button type="submit">Iniciar Sesión</button>
            </div>

        </form>
    </div>

</body>
</html>