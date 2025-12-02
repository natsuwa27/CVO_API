<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Empleado - Veterinaria del Oriente</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #007bff; 
            --secondary-color: #28a745;
            --navbar-color: #3f98ff;
            --bg-light: #f4f9ff;
            --section-bg: #e6f3ff;
        }
        
        body { 
            background: var(--bg-light); 
            font-family: 'Poppins', sans-serif;
            padding-top: 80px;
        }
        
        
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
            font-size: 2rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        
        .section-box { 
            background: var(--section-bg); 
            padding: 40px; 
            border-radius: 15px; 
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        .card-custom {
            transition: transform 0.3s, box-shadow 0.3s;
            border-radius: 10px;
            border: none;
        }
        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .icon-lg {
            font-size: 3rem;
            margin-bottom: 15px;
        }
        .card-title {
            font-weight: 600;
        }

        
        footer { 
            background: #018ABE;
            padding: 40px; 
            margin-top: 80px; 
            color: white; 
            text-align: center;
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
                <li class="nav-item active"><a class="nav-link" href="#">Panel Principal</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Servicios</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Finanzas</a></li>
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
        <h1 class="hero-title">Panel de Empleado | {{ Auth::user()->name }}</h1>
        <p class="lead font-weight-light">Bienvenido al centro de operaciones. Mantén el servicio eficiente.</p>
    </div>
</div>

<main class="container">
    <div class="mt-4 mb-5">
         <h2 class="font-weight-bold text-center text-primary">Tareas Operacionales Rápidas</h2>
    </div>

    <section class="row">
        
        <div class="col-md-4 mb-4">
            <div class="card card-custom text-center">
                <div class="card-body">
                    <h4 class="icon-lg text-info">📅</h4>
                    <h5 class="card-title text-info">Gestión de Citas</h5>
                    <p class="card-text text-muted">Revisa la agenda del día, confirma y crea nuevas citas.</p>
                    <a href="#" class="btn btn-info btn-block mt-3">Ver Citas Hoy</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card card-custom text-center">
                <div class="card-body">
                    <h4 class="icon-lg text-primary">📦</h4>
                    <h5 class="card-title text-primary">Control de Inventario</h5>
                    <p class="card-text text-muted">Gestiona stock de medicamentos, vacunas y alimentos.</p>
                    <a href="#" class="btn btn-primary btn-block mt-3">Gestionar Stock</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card card-custom text-center">
                <div class="card-body">
                    <h4 class="icon-lg text-success">🐶</h4>
                    <h5 class="card-title text-success">Registro y Búsqueda</h5>
                    <p class="card-text text-muted">Registra nuevos clientes/mascotas o busca historiales.</p>
                    <a href="#" class="btn btn-success btn-block mt-3">Buscar Cliente</a>
                </div>
            </div>
        </div>
        
    </section>

    <hr>
    
    <section class="section-box mt-5">
        <h3 class="mb-4 text-primary font-weight-bold">🗓️ Próximas Citas (Prioridad)</h3>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Hora</th>
                        <th>Mascota</th>
                        <th>Cliente</th>
                        <th>Motivo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>09:00 AM</td>
                        <td>Firulais (Perro)</td>
                        <td>Juan Pérez</td>
                        <td>Vacunación Anual</td>
                        <td><a href="#" class="btn btn-sm btn-info">Ver Detalle</a></td>
                    </tr>
                    <tr>
                        <td>10:30 AM</td>
                        <td>Michi (Gato)</td>
                        <td>Ana Gómez</td>
                        <td>Consulta General</td>
                        <td><a href="#" class="btn btn-sm btn-info">Ver Detalle</a></td>
                    </tr>
                    </tbody>
            </table>
        </div>
    </section>

</main>

<footer>
    <div class="container">
        <p>&copy; 2025 Veterinaria del Oriente. Panel de Empleado.</p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
