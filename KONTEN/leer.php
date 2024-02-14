<?php
session_start();

?>

<?php 
include "templates/header.php"; 
include 'funciones.php';

$error = false;
$config = include 'config.php';

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
  
    if (isset($_POST['cedula'])) {
      $consultaSQL = "SELECT * FROM clientes WHERE cedula LIKE '%" . $_POST['cedula'] . "%'";
    } else {
      $consultaSQL = "SELECT * FROM clientes";
    }
  
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();
  
    $clientes = $sentencia->fetchAll();
  
  } catch(PDOException $error) {
    $error= $error->getMessage();
  }
  
  $titulo = isset($_POST['cedula']) ? 'Cliente ' . $_POST['cedula'] . '' : 'Cliente';
  ?>
  
  <?php include "templates/header.php"; ?>
  
  <?php
  if ($error) {
    ?>
    <div class="container mt-2">
      <div class="row">
        <div class="col-md-12">
          <div class="alert alert-danger" role="alert">
            <?= $error ?>
          </div>
        </div>
      </div>
    </div>
    <?php
  }
  ?>
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
                        <div >
                          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <div class="text-muted">
                              <button type="button" class="btn btn-outline-secondary">
                                <a href="cerrar_sesion.php" class="text-decoration-none text-white">Cerrar sesion</a>
                              </button>
                            </div>
                          </ul>
                        </div>
                    </div>
              </nav>
              <div id="login" class="contenedor">
                    
                <div class="titulo_logo">
                    <p>
                    <h4 class="text-center">Buscar cliente</h4>
                    </p>

                              <div class="container">
                                <div class="row">
                                  <div class="col-xs-5">
                                    <form method="post" class="form-inline">
                                      <div class="form-group col-auto">
                                      <p>
                                      <input type="text" id="cedula" name="cedula" placeholder="Ingrese el numero de cedula" class="form-control text-center" >
                                      </p>
                                      </div>
                                        <div class="d-grid gap-2">
                                        <button type="submit" name="submit" class="btn btn-primary col-6 mx-auto">Buscar</button>
                                        </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            <?php
                            if ($clientes && $sentencia->rowCount() > 0) {
                              foreach ($clientes as $fila);
                              }
                            else {
                                echo"<div class='alert alert-danger text-center mt-3'>El cliente no existe</div>" ;
                              }
                            ?>
                                <div class="container">
                                  <h4 class="mt-3 text-center"><?= $titulo ?></h4>
                                    <div class="row row-cols-2 text-center">
                                      <div class="container">
                                        <img src="img/image (1).png" class="img-fluid img-thumbnail"alt="">
                                        <label>Abonar</label>
                                      </div>
                                      <div class="col">
                                      <img src="img/image (2).png" class="img-fluid img-thumbnail"alt="">
                                     
                                      <a href="<?= 'editar.php?id=' . escapar($fila["id"]) ?>" . ><label>Editar</label></a>
                                      <a href="<?= 'borrar.php?id=' . escapar($fila["id"]) ?>" ><label>Borrar</label></a>

                                      </div>
                                      <div class="col">
                                      <img src="img/image (3).png" class="img-fluid img-thumbnail" alt="">
                                      <label>Anotar</label>
                                      </div>
                                      <div class="col">
                                      <img src="img/image (4).png" class="img-fluid img-thumbnail" alt="">
                                      <label>Pagar</label>
                                      </div>
                                    </div>
                                </div>
                           
                            <div class="d-grid gap-2 d-md-block text-center">
                            <p>
                            <a href="crear.php"  class="btn btn-primary mt-2">Agregar Cliente</a>
                            </p>                     
                    </div>
              </div>
        </div>
  </div>
<?php include "templates/footer.php";?>