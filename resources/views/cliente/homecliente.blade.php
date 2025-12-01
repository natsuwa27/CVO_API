<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Cliente</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body { background:#f4f9ff; }
        .navbar { position:fixed; top:0; width:100%; z-index:2000; }
        .hero { width:100%; height:300px; background:url('{{ asset("css/banner-mascotas.jpg") }}') center/cover; position:relative; margin-top:80px; }
        .logo-central { width:180px; height:180px; border-radius:50%; background:white; padding:15px; position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); }
        .mascota-item img { width:90px; height:90px; border-radius:50%; object-fit:cover; }
        .section-box { background:#d2eeff; padding:30px; border-radius:15px; }
        footer { background:#018ABE; padding:40px; margin-top:80px; color:white; }
    </style>
</head>
<body>

<!-- Barra superior -->
<nav class="navbar navbar-expand-lg" style="background-color:#4EBFEB;">
    <div class="container">
        <a href="#" class="navbar-brand text-white font-weight-bold">
            <img src="{{ asset('css/logo.jpg') }}" width="45"> Veterinaria del Oriente
        </a>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link text-white" href="#">Inicio</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#">Mis mascotas</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#">Agendar una cita</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#">Sobre nosotros</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#">Perfil</a></li>
        </ul>
    </div>
</nav>

<!-- Título bienvenida -->
<div class="container mt-5 pt-4">
    <h2 class="font-weight-bold">Bienvenido {{ Auth::user()->name }}:</h2>
</div>

<!-- Banner -->
<div class="hero">
    <img src="{{ asset('css/logo.jpg') }}" class="logo" />
</div>

<!-- Mis mascotas -->
<div class="container mt-5">
    <h3 class="font-weight-bold">Mis mascotas</h3>
    <p>Pulsa el perfil de tu mascota para ver su información</p>

    <div class="d-flex">
        <div class="mascota-item text-center mx-3">
            <a href="#"><img src="{{ asset('css/huellita.jpg') }}"></a>
            <p>Agregar Mascota</p>
        </div>
        <div class="mascota-item text-center mx-3">
            <img src="{{ asset('css/perrito.jpg') }}"><p>Toby</p>
        </div>
        <div class="mascota-item text-center mx-3">
            <img src="{{ asset('css/gato.jpg') }}"><p>Furcio</p>
        </div>
        <div class="mascota-item text-center mx-3">
            <img src="{{ asset('css/perrito2.jpg') }}"><p>Ferríño</p>
        </div>
    </div>
</div>

<!-- Agendar citas -->
<div class="container mt-5">
    <h3 class="font-weight-bold">Agendar citas</h3>

    <div class="row mt-3">
        <div class="col-md-6">
            <p style="font-size:18px;">¿Necesitas una consulta, baño o dejar a tu mascota en guardería? Usa estas opciones para programar o consultar tus citas fácilmente.</p>
        </div>
        <div class="col-md-6">
            <div class="section-box text-center">
                <a href="#" class="btn btn-outline-primary btn-lg mb-3">📅 Programar cita</a><br>
                <a href="#" class="btn btn-outline-primary btn-lg">👁 Ver citas registradas</a>
            </div>
        </div>
    </div>
</div>

<!-- Información general -->
<div class="container mt-5">
    <h3 class="font-weight-bold">Información General</h3>

    <div class="row mt-3">
        <div class="col-md-6">
            <img src="{{ asset('css/ubi.jpg') }}" class="img-fluid rounded shadow">
        </div>
        <div class="col-md-6">
            <h4>¿Quiénes somos?</h4>
            <p>En Veterinaria del Oriente... (texto completo aquí)</p>
        </div>
    </div>
</div>

<!-- Ubicación -->
<div class="container mt-5">
    <h3 class="font-weight-bold">¿Dónde nos encontramos?</h3>
    <p style="font-size:20px;">Periférico 9344, Torreón</p>

    <div class="row">
        <div class="col-md-6"><img src="{{ asset('css/mapa.jpg') }}" class="img-fluid"></div>
        <div class="col-md-6"><img src="{{ asset('css/promo.jpg') }}" class="img-fluid"></div>
    </div>
</div>

<!-- Footer -->
<footer class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4"><h5>Información</h5><p>Términos y condiciones</p><p>Privacidad</p><p>Contacto</p></div>
            <div class="col-md-4"><h5>Secciones</h5><p>Inicio</p><p>Mis mascotas</p><p>Agendar cita</p></div>
            <div class="col-md-4"><h5>Síguenos</h5><p>Facebook</p><p>Instagram</p></div>
        </div>
    </div>
</footer>

</body>
</html>