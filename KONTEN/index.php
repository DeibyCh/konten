<?php 
include "templates/header.php"; 
include 'funciones.php';
?>


<link rel="stylesheet" href="css/leer.css">

<div id="contenedor">
  <div id="central">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <div class="container-fluid ">
                    <a class="navbar-brand ">KONTEN</a>
                    </div>
        </nav>
    <div id="login" class="contenedor">
      <div class="titulo">           
            <div class="container text-center" >
            <img src="img/LOGO KONTEN.png" width="100%" alt="Logo">
            </div>
            <div class="container text-center mt-5" >
            <img src="img/usuario.png" width="25%" alt="">
            <hr>
            <p>
            <?php
            include "conexion.php";
            include "controlador.php";
            ?>
            </p>

          </div>

          
        <form method="post">
            <div class="mb-2 text-center mt-4" >
            <label for="usuario" class="form-label">Usuario</label>
            <input type="text" class="form-control text-center" id="usuario" name="usuario">
            
          </div>
          <div class="mb-2 text-center">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control text-center" id="password" name="password">
          </div>
          <div class="container text-center mb-3" >
            <a href="#" class="link-info">Olvidaste tu contraseña?</a>
          </div>
          <div class="d-grid gap-2">
                <input name="enviar" type="submit" name="submit" class="btn btn-primary " >
                <a class="btn btn-secondary " href="registrar.php">Registrar</a>
          </div>        
          </form>

        

      </div>
    </div>
  </div>
</div>
<?php include "templates/footer.php"; ?>