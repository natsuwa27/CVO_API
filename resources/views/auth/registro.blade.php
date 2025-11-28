<!DOCTYPE html>
<html lang="es">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/Estilos.css">


<body class="d-flex flex-column align-items-center">


     <div id="BarraTop">
      <div class="d-flex flex-column align-items-center mt-2">
        <h3 style="color:white">Veterinaria del oriente</h3>
      </div>
     </div>


<div class="col-10 d-flex justify-content-center mt-2">
  <div class="container d-flex justify-content-center mt-5"
       style="background-color: var(--color-contenedor); border-radius: 5px; height: 400px; padding: 20px;">

    <div class="row w-100">

  
      <div class="col-6">
        <label>Nombre de usuario</label>
        <input type="text" class="input-form" placeholder="...">

        <label>Teléfono</label>
        <input type="tel" class="input-form" placeholder="...">

        <label>Email</label>
        <input type="email" class="input-form" placeholder="...@gmail.com">
      </div>

      <div class="col-6">
        <label>Contraseña</label>
        <div class="input-pass">
          <input type="password" class="input-form" placeholder="********">
        </div>

        <label>Confirmar contraseña</label>
        <div class="input-pass">
          <input type="password" class="input-form" placeholder="********">
        </div>

        <label>Domicilio</label>
        <input type="text" class="input-form" placeholder="....">
      </div>

      <div class="col-12 mt-3 d-flex justify-content-center">
        <div id="ContenedorRegistro">
         <button  onclick="window.location.href='Bienvenida.html'">Confirmar</button>
        </div>
      </div>

    </div>

  </div>
</div>





      <div id="BarraBottom" class="d-flex flex-column align-items-center mt-2"></div>
     
</body>









</html>
