<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cliente - Veterinaria del Oriente</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <style>
        :root {
            --primary-color: #007bff; /* Azul vibrante */
            --secondary-color: #28a745; /* Verde para acciones */
            --navbar-color: #3f98ff; /* Azul claro para barra */
            --bg-light: #f4f9ff;
            --section-bg: #e6f3ff; /* Azul muy claro para secciones */
        }
        
        body { 
            background: var(--bg-light); 
            font-family: 'Poppins', sans-serif;
            padding-top: 80px;
        }
        
        /* Barra de Navegación */
        .navbar { 
            position: fixed; 
            top: 0; 
            width: 100%; 
            z-index: 2000;
            background-color: var(--navbar-color) !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand img { 
            margin-right: 10px; 
            border-radius: 50%;
        }
        .nav-link {
            color: white !important;
            font-weight: 500;
            transition: color 0.3s;
        }
        .nav-link:hover {
            color: #ffc107 !important;
        }

        /* Hero Section */
        .hero { 
            width: 100%; 
            height: 300px;
            background: linear-gradient(rgba(0, 123, 255, 0.7), rgba(0, 123, 255, 0.7)), url('{{ asset("css/banner-mascotas.jpg") }}') center/cover;
            background-attachment: fixed;
            position: relative; 
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-bottom: 50px;
            border-radius: 0 0 50% 50% / 0 0 10% 10%;
        }
        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        /* Card y Secciones */
        .section-box { 
            background: var(--section-bg); 
            padding: 30px; 
            border-radius: 15px; 
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        .mascota-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            height: 100%;
        }
        .mascota-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .mascota-img { 
            width: 100%; 
            height: 150px; 
            object-fit: cover;
        }
        .mascota-add-card {
            border: 2px dashed var(--primary-color);
            background: white;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-decoration: none;
        }
        .mascota-add-card:hover {
            background: var(--section-bg);
            text-decoration: none;
        }
        .mascota-add-card h4 {
            font-size: 1.25rem;
            margin-top: 10px;
        }

        /* Footer */
        footer { 
            background: #018ABE;
            padding: 40px; 
            margin-top: 80px; 
            color: white; 
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a href="#" class="navbar-brand font-weight-bold">
            <img src="{{ asset('css/logo.jpg') }}" width="45" alt="Logo Veterinaria"> Veterinaria del Oriente
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a class="nav-link" href="#">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Mis Mascotas</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Agendar Cita</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Sobre Nosotros</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Perfil</a></li>
                <li class="nav-item ml-lg-3">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-warning btn-sm" type="submit">
                            Cerrar sesión
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="hero">
    <div class="container">
        <h1 class="hero-title">¡Hola, {{ Auth::user()->name }}!</h1>
        <p class="lead font-weight-light">Bienvenido a tu panel. Cuidemos juntos de tus mascotas.</p>
    </div>
</div>

<main class="container">

    <section class="section-box">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-primary font-weight-bold">🐾 Mis Mascotas</h3>
            <a href="#" class="btn btn-secondary"><i class="fas fa-plus-circle"></i> Agregar Nueva Mascota</a>
        </div>
        
        <div class="row">
            <div class="col-6 col-md-3 mb-4">
                <a href="#" class="mascota-add-card p-3 text-center" style="height: 100%;">
                    <i class="fas fa-paw fa-3x"></i>
                    <h4>Agregar Mascota</h4>
                    <p class="small mb-0">¡Empieza su historial!</p>
                </a>
            </div>

            <div class="col-6 col-md-3 mb-4">
                <div class="mascota-card text-center">
                    <img src="{{ asset('css/perrito.jpg') }}" class="mascota-img" alt="Foto de Toby">
                    <div class="p-3">
                        <h5 class="font-weight-bold mb-1">Toby</h5>
                        <p class="text-muted small">Última cita: 01/Nov/2025</p>
                        <a href="#" class="btn btn-sm btn-outline-primary btn-block">Ver Expediente</a>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3 mb-4">
                <div class="mascota-card text-center">
                    <img src="{{ asset('css/gato.jpg') }}" class="mascota-img" alt="Foto de Furcio">
                    <div class="p-3">
                        <h5 class="font-weight-bold mb-1">Furcio</h5>
                        <p class="text-muted small">Última cita: 15/Oct/2025</p>
                        <a href="#" class="btn btn-sm btn-outline-primary btn-block">Ver Expediente</a>
                    </div>
                </div>
            </div>
            
            <div class="col-6 col-md-3 mb-4">
                <div class="mascota-card text-center">
                    <img src="{{ asset('css/perrito2.jpg') }}" class="mascota-img" alt="Foto de Ferríño">
                    <div class="p-3">
                        <h5 class="font-weight-bold mb-1">Ferríño</h5>
                        <p class="text-muted small">Última cita: 20/Nov/2025</p>
                        <a href="#" class="btn btn-sm btn-outline-primary btn-block">Ver Expediente</a>
                    </div>
                </div>
            </div>

            </div>
    </section>

    <hr>

    <section class="section-box bg-white">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h3 class="text-info font-weight-bold mb-3">📅 Agendar y Consultar Citas</h3>
                <p style="font-size:18px;">¿Necesitas una consulta, baño o guardería? Programa tu próxima visita o revisa el estado de tus citas registradas fácilmente.</p>
                
                <div class="alert alert-warning mt-3">
                    Tienes una cita pendiente para Toby el 15/Dic/2025 a las 11:00 AM.
                </div>
            </div>
            <div class="col-md-5 text-center">
                <div class="p-3 border rounded shadow-sm bg-light">
                    <a href="#" class="btn btn-success btn-lg btn-block mb-3"><i class="far fa-calendar-alt"></i> Programar Nueva Cita</a>
                    <a href="#" class="btn btn-outline-primary btn-block"><i class="fas fa-history"></i> Ver Historial de Citas</a>
                </div>
            </div>
        </div>
    </section>
    
    <hr>

    <section class="mt-5">
        <h2 class="font-weight-bold text-center text-secondary mb-4">Conócenos y Encuéntranos</h2>
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="section-box">
                    <h4 class="font-weight-bold text-primary">🏥 ¿Quiénes somos?</h4>
                    <p>En Veterinaria del Oriente, somos un equipo de profesionales comprometidos con el bienestar y la salud de tus mascotas. Brindamos atención médica integral, ética y de calidad en un ambiente cálido y de confianza. Creemos que cada animal es un miembro importante de la familia, por eso los tratamos con respeto, cariño y profesionalismo.</p>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="section-box bg-white">
                    <h4 class="font-weight-bold text-success">📍 ¿Dónde estamos?</h4>
                    <p class="lead mb-2">**Periférico 9344, Torreón**</p>
                    <div class="mb-3">
                        <img src="{{ asset('css/mapa.jpg') }}" class="img-fluid rounded shadow" alt="Mapa de ubicación">
                    </div>
                    <a href="#" class="btn btn-warning btn-block font-weight-bold mt-3"><i class="fas fa-phone"></i> ¡Llámanos! (123) 456-7890</a>
                </div>
            </div>
        </div>
    </section>

</main>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5 class="mb-3">Información</h5>
                <p class="small mb-1"><a href="#" class="text-white">Términos y condiciones</a></p>
                <p class="small mb-1"><a href="#" class="text-white">Política de Privacidad</a></p>
                <p class="small"><a href="#" class="text-white">Contacto</a></p>
            </div>
            <div class="col-md-4">
                <h5 class="mb-3">Secciones</h5>
                <p class="small mb-1"><a href="#" class="text-white">Inicio</a></p>
                <p class="small mb-1"><a href="#" class="text-white">Mis mascotas</a></p>
                <p class="small"><a href="#" class="text-white">Agendar cita</a></p>
            </div>
            <div class="col-md-4">
                <h5 class="mb-3">Síguenos</h5>
                <p class="small mb-1">Facebook / Instagram</p>
                <p class="small">© 2025 Veterinaria del Oriente</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
