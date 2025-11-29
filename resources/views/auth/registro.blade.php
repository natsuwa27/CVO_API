<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/Estilos.css"> 
</head>

<body class="d-flex flex-column align-items-center">

    <div id="BarraTop">
        <div class="d-flex flex-column align-items-center mt-2">
            <h3 style="color:white">Veterinaria del oriente</h3>
        </div>
    </div>

    <div class="col-10 d-flex justify-content-center mt-2">
        <div class="container d-flex justify-content-center mt-5"
            style="background-color: var(--color-contenedor); border-radius: 5px; height: 450px; width:800px; padding:20px;">

            <form method="POST" action="/registro" class="w-100">
                @csrf 
                <div class="row w-100">

                    <div class="col-6">
                        <label>Nombre de usuario</label>
                        <input type="text" name="name" class="input-form" placeholder="Nombre completo" required>

                        <label>Teléfono</label>
                        <input type="tel" name="phone" class="input-form" placeholder="Teléfono" >

                        <label>Email</label>
                        <input type="email" name="email" class="input-form" placeholder="...@gmail.com" required>
                    </div>

                    <div class="col-6">
                        <label>Contraseña</label>
                        <input type="password" name="password" class="input-form" placeholder="********" required>

                        <label>Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" class="input-form" placeholder="********" required>

                        <label>Domicilio</label>
                        <input type="text" name="address" class="input-form" placeholder="Domicilio">
                    </div>

                    <div class="col-12 mt-3 d-flex justify-content-center">
                        <button type="submit">Confirmar Registro</button>
                    </div>
                </div>

            </form>
            </div>
    </div>

</body>
</html>