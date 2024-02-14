<?php
session_start();
?>
<?php

include 'funciones.php';

$config = include 'config.php';
$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (!isset($_GET['id'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El cliente no existe';
}

if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $clientes = [
      "id"         => $_GET['id'],
      "nombres"    => $_POST['nombres'],
      "apellidos"  => $_POST['apellidos'],
      "direccion"  => $_POST['direccion'],
      "telefono"   => $_POST['telefono']
    ];
    
    $consultaSQL = "UPDATE clientes SET
        nombres = :nombres,
        apellidos = :apellidos,
        direccion = :direccion,
        telefono = :telefono,
        updated_at = NOW()
        WHERE id = :id";
    
    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($clientes);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
  $id = $_GET['id'];
  $consultaSQL = "SELECT * FROM clientes WHERE id =" . $id;

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $cliente = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$cliente) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el cliente';
  }

} catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<?php require "templates/header.php"; ?>

<?php
if ($resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>



<?php if (isset($cliente) && $cliente) {
?>

<link rel="stylesheet" href="css/leer.css">

<div id="contenedor">
    <div id="central">
    <?php
      if (isset($_POST['submit']) && !$resultado['error']) {
        ?>
        <div class="container mt-2">
          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-success" role="alert">
                El cliente ha sido actualizado correctamente
              </div>
            </div>
          </div>
        </div>
        <?php
      }
    ?>
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
                    <p>
                        <div class="container">
                            <div class="col">
                              <h5 class="mt-4 text-center" >Editando a <?= escapar($cliente['nombres']) . ' ' . escapar($cliente['apellidos'])  ?></h5>
                              <hr>
                              <form method="post">
                                <div class="form-group">
                                  <label for="nombres">Nombres</label>
                                  <input type="text" name="nombres" id="nombres" value="<?= escapar($cliente['nombres']) ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                  <label for="apellidos">Apellidos</label>
                                  <input type="text" name="apellidos" id="apellidos" value="<?= escapar($cliente['apellidos']) ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                  <label for="direccion">Direccion</label>
                                  <input type="text" name="direccion" id="direccion" value="<?= escapar($cliente['direccion']) ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                  <label for="telefono">Telefono</label>
                                  <input type="tel" name="telefono" id="telefono" value="<?= escapar($cliente['telefono']) ?>" class="form-control">
                                </div>
                                <div class="d-grid gap-2">
                                  <hr>
                                  <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
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
  <?php
}
?>

<?php require "templates/footer.php"; ?>