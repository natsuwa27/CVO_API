<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cliente - Veterinaria del Oriente</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        :root {
            --primary-color: #007bff; /* Azul vibrante */
            --navbar-color: #3f98ff; /* Azul claro */
            --bg-light: #f4f9ff;
            --card-bg: white;
            --button-color: #28a745; /* Verde para la acción de registro */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light); 
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 80px; /* Espacio para la barra superior */
        }

        /* Encabezado fijo */
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
        .registro-container {
            background-color: var(--card-bg);
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            padding: 30px;
            width: 90%;
            max-width: 850px; /* Más ancho para las dos columnas */
            margin-bottom: 40px;
        }

        /* Estilos de inputs y labels */
        label {
            display: block;
            font-weight: 500;
            margin-top: 10px;
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
        .btn-registro {
            padding: 12px 30px;
            background-color: var(--button-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }
        .btn-registro:hover {
            background-color: #1e7e34;
            transform: translateY(-1px);
        }
        
        /* Estilos para mensajes de error */
        .alert-danger, .alert-success {
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

    <div class="registro-container mt-4">

        <div class="text-center mb-4">
            <h2 class="font-weight-bold text-success">Crea tu Cuenta de Cliente</h2>
            <p class="text-muted">¡Solo unos datos y estarás listo para agendar citas!</p>
        </div>
        
        <form method="POST" action="/registro" class="w-100">
            @csrf 
            <div class="row">

                <div class="col-md-6">
                    <label for="name"><i class="fas fa-user mr-2"></i> Nombre Completo</label>
                    <input type="text" id="name" name="name" class="input-form" placeholder="Nombre y Apellidos" required value="{{ old('name') }}">

                    <label for="phone"><i class="fas fa-phone-alt mr-2"></i> Teléfono</label>
                    <input type="tel" id="phone" name="phone" class="input-form" placeholder="Ej: 555-123-4567" value="{{ old('phone') }}">

                    <label for="email"><i class="fas fa-envelope mr-2"></i> Email</label>
                    <input type="email" id="email" name="email" class="input-form" placeholder="correo@ejemplo.com" required value="{{ old('email') }}">
                </div>

                <div class="col-md-6">
                    <label for="password"><i class="fas fa-lock mr-2"></i> Contraseña</label>
                    <input type="password" id="password" name="password" class="input-form" placeholder="Mínimo 8 caracteres" required>

                    <label for="password_confirmation"><i class="fas fa-check-double mr-2"></i> Confirmar Contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="input-form" placeholder="Repite tu contraseña" required>

                    <label for="address"><i class="fas fa-map-marker-alt mr-2"></i> Domicilio</label>
                    <input type="text" id="address" name="address" class="input-form" placeholder="Calle, número, colonia" value="{{ old('address') }}">
                </div>

                <div class="col-12 mt-4 text-center">
                    <button type="submit" class="btn-registro">
                        <i class="fas fa-paw mr-2"></i> Confirmar Registro
                    </button>
                </div>
            </div>

        </form>
        
        <div class="text-center mt-4 pt-3 border-top">
            <p class="small text-muted mb-0">¿Ya tienes una cuenta? 
                <a href="{{ route('login') }}" class="text-primary font-weight-bold">Inicia Sesión aquí</a>
            </p>
        </div>

    </div>

</body>
</html>