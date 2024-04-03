<?php
session_start();
?>
<?php

include 'funciones.php';

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El cliente ' . $_POST['nombre'] . ' ha sido creado con éxito' 
  ];
  $config = include 'config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $clientes = array(
      "nombres"   => $_POST['nombre'],
      "apellidos" => $_POST['apellido'],
      "cedula"    => $_POST['cedula'],
      "direccion" => $_POST['direccion'],
      "telefono"  => $_POST['telefono'],
    );
    
    $consultaSQL = "INSERT INTO clientes (nombres, apellidos, cedula, direccion, telefono)";
    $consultaSQL .= "values (:" . implode(", :", array_keys($clientes)) . ")";
    
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($clientes);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}
?>
<?php include "templates/header.php"; ?>

<link rel="stylesheet" href="css/leer.css">
  <div id="contenedor">
    <div id="central">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand">KONTEN</a>
            <div class="text-center text-muted">
              <?php
              echo $_SESSION["nombre"];
              ?>
            </div>
        </div>
      </nav>
        <div id="login" class="contenedor">
          <div class="titulo_logo">
            <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <p>
                    <h5 class="subtitle text-center">Registrar cliente</h5>
                  </p>
                  <hr>
                    <form method="post">
                      <div class="form-group">
                        <label for="nombre">Nombres</label>
                          <input type="text" name="nombre" id="nombre" class="form-control">
                      </div>
                        <div class="form-group">
                          <label for="apellido">Apellidos</label>
                            <input type="text" name="apellido" id="apellido" class="form-control">
                        </div>
                        <p> 
                          <select class="form-select mt-2" aria-label="Default select example">
                            <option selected>Tipo de documento</option>
                            <option value="1">Cedula Ciudadania</option>
                            <option value="2">Cedula Extranjeria</option>
                            <option value="3">Pasaporte</option>
                          </select>
                        </p>
                          <div class="form-group">
                            <label for="cedula">Numero de documento</label>
                              <input type="id" name="cedula" id="cedula" class="form-control">
                          </div>
                            <div class="form-group">
                             <label for="telefono">Telefono</label>
                              <input type="tel" name="telefono" id="telefono" class="form-control">
                            </div>
                              <div class="form-group">
                                <label for="direccion">Direccion</label>
                                  <input type="text" name="direccion" id="direccion" class="form-control">
                              </div>
                              <?php
                              if (isset($resultado)) {
                              ?>
                              <div class="container mt-3 text-center">
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
                              <div class="d-grid gap-2 mt-4">
                                <input type="submit" name="submit" class="btn btn-primary " value="Enviar">
                                  <a class="btn btn-secondary" href="leer.php">Regresar al inicio</a>
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