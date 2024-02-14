
<?php

include 'funciones.php';

if (isset($_POST['submit'])) 
{
  $resultado = [
    'error' => false,
    'mensaje' => 'El usuario ' . $_POST['nombre'] . ' ha sido agregado con éxito' 
  ];
  $config = include 'config.php';

  try 
  
  {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $usuario = array(
      "nombres"     => $_POST['nombre'],
      "apellidos"   => $_POST['apellido'],
      "usuario"     => $_POST['usuario'],
      "password"  => $_POST['password'],
      "telefono"    => $_POST['telefono'],
    );
    
    $consultaSQL = "INSERT INTO `konten`.`usuarios` (`id`, `password`, `telefono`, `usuario`, `nombres`, `apellidos`);";
    $consultaSQL = "values (:" . implode(", :", array_keys($usuario)) . ")";
    
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($usuario);

  } 
    catch(PDOException $error) 
    {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
    }
}
?>
<?php include "templates/header.php"; ?>




<link rel="stylesheet" href="css/leer.css">

<div id="contenedor">
          <div id="central">
          <?php
            if (isset($resultado)) {
            ?>
            <div class="container mt-3">
                <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
                    <?= $resultado['mensaje'] ?>
                    </div>
                </div>
                </div>
            </div>
            <?php
            }
        ?>
                
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <div class="container-fluid ">
                    <a class="navbar-brand ">KONTEN</a>
                    </div>
                </nav>
                <div id="login" class="contenedor">
                    <div class="titulo_logo">
                            <div class="container">
                                        <div class="row">
                                        <div class="col-md-12">
                                          <p>
                                          <h4 class="subtitle text-center">Registrar usuario</h4>
                                          </p>
                                          <hr>
                                              <form method="post">
                                                  <div class="form-group">
                                                  <label for="usuario">Usuario</label>
                                                  <input type="id" name="usuario" id="usuario" class="form-control">
                                                  </div>
                                                  <div class="form-group">
                                                  <label for="password">Contraseña</label>
                                                  <input type="password" name="password" id="password" class="form-control">
                                                  </div>
                                                  <div class="form-group">
                                                  <label for="nombre">Nombres</label>
                                                  <input type="text" name="nombre" id="nombre" class="form-control">
                                                  </div>
                                                  <div class="form-group">
                                                  <label for="apellido">Apellidos</label>
                                                  <input type="text" name="apellido" id="apellido" class="form-control">
                                                  </div>
                                                  <div class="form-group">
                                                  <label for="telefono">Telefono</label>
                                                  <input type="phone" name="telefono" id="telefono" class="form-control">
                                                  </div>
                                                  <div class="d-grid gap-2 mt-4">
                                                  <input type="submit" name="submit" class="btn btn-primary " value="Enviar">
                                                  <a class="btn btn-secondary" href="index.php">Regresar al inicio</a>
                                                  </div>
                                              </form>
                                      </div>
                                  </div>
                              </div>
              </div>
            </div>
          </div>
      </div>
<?php include "templates/footer.php"; ?>