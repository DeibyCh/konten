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
  
  //Mostrar cedula y saldo
  $titulo1 = '';
  $titulo2 = '';
  if (isset($clientes[0])) {
      $titulo1 = 'Cliente: ' . $_POST['cedula'];
      $titulo2 = 'Saldo: ' . $clientes[0]["saldo"];
  }
  
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

    <!--Barra de sesion -->

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

      <!--Body-->

      <div id="login" class="contenedor">
        <div class="titulo_logo">
          <h4 class="text-center">Buscar cliente</h4>
            <div class="container">
              <div class="row">
                <div class="col-xs-5">
                  <form method="post" class="form-inline">
                    <div class="form-group col-auto">
                      <p>
                        <input type="numb" id="cedula" name="cedula" placeholder="Ingrese el numero de cedula" class="form-control text-center" >
                      </p>
                    </div>
                      <div class="d-grid gap-2">
                        <button type="submit" name="submit" class="btn btn-primary col-6 mx-auto">Buscar</button>
                      </div>
                  </form>
                </div>
              </div>
            </div>

              <!--Aviso emergente-->

              <?php
                if ($clientes && $sentencia->rowCount() > 0) {
                  foreach ($clientes as $fila);
                }
                  else {
                  echo"<div class='alert alert-danger text-center mt-3'>El cliente no existe</div>" ;
                }
              ?>
              <!-- imagenes -->

                <div class="container" >
                  <h4 class="mt-2 text-center" display="none"><?= $titulo1 ?><br><?= $titulo2 ?></h4>
                    <div class="row row-cols-2 text-center" id="micontenedor" >
                      <div class="container-fluid">
                        <img class="btn-outline-secondary img-fluid img-thumbnail" onclick="toggleContenedor1()" id="abonar" src="img/image (1).png">
                          <label><button class="btn btn-light" >Abonar</button></label>
                      </div>
                        <div class="col">
                          <img class="btn-outline-secondary img-fluid img-thumbnail" src="img/image (2).png">
                            <div class="d-grid gap-2 d-md-block">
                              <a class="btn btn-warning btn-sm " role="button" href="<?= 'editar.php?id=' . escapar($fila["id"]) ?>" . ><label>Editar</label></a>
                                <a class="btn-danger btn-sm " role="button" onclick="return confirmacion()" href="<?= 'borrar.php?id=' . escapar($fila["id"]) ?>" ><label>Borrar</label></a>
                            </div>  
                        </div>
                          <div class="col">
                            <img class="btn-outline-secondary img-fluid img-thumbnail" onclick="toggleContenedor2()"id="anotar" src="img/image (3).png" >
                              <label><button class="btn btn-light" >Anotar</button></label>                                      
                          </div>
                            <div class="col">
                              <img class="btn-outline-secondary img-fluid img-thumbnail" onclick="toggleContenedor3()" id="pagar" src="img/image (4).png" >
                                <label><button class="btn btn-light" >Pagar</button></label>                                      
                            </div>
                      </div>
                  </div>   
                               
                  <!--Imputs emerjentes -->

                  <!--Abonar -->

                  <div id="cont-abonar" style="display: none;" class="container mt-2">
                    <div class="row">
                      <div class="col-xs-5">
                        <!--envio id del cliente-->
                        <form action="<?='abonar.php?id=' . escapar($fila["id"]) ?>" method="POST" autocomplete="off" class="form-inline" id="inputContainer">
                          <div class="form-group col-auto">
                            <p>
                              <input type="number" id="abonar" name="abonar" placeholder="Ingrese el valor abonar" class="form-control text-center" >
                            </p>
                          </div>
                          <div class="d-grid gap-2">
                            <button type="submit" name="submit" value="Actualizar saldo" class="btn btn-primary col-6 mx-auto">Enviar</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  
                  <!--Anotar-->

                  <div id="cont-anotar" style="display: none;" class="container mt-2">
                    <div class="row">
                      <div class="col-xs-5">
                        <!--envio id del cliente-->
                        <form action="<?='anotar.php?id=' . escapar($fila["id"]) ?>" method="POST" autocomplete="off" class="form-inline" id="inputContainer">
                        
                          <div class="form-group col-auto">
                            <p>
                              <input type="text" id="anotar" name="anotar" placeholder="Ingrese el valor anotar" class="form-control text-center" >
                            </p>
                          </div>
                          <div class="d-grid gap-2">
                            <button type="submit" name="submit" class="btn btn-primary col-6 mx-auto">Enviar</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <!--Pagar-->

                  <div id="cont-pagar" style="display: none;" class="container mt-2">
                    <div class="row">
                      <div class="col-xs-5">
                      <form action="<?='pagar.php?id=' . escapar($fila["id"]) ?>" method="POST" autocomplete="off" class="form-inline" id="inputContainer">
                          <div class="form-group col-auto">
                            <p>
                              <input type="text" id="pagar" name="pagar" placeholder="Ingrese el valor a pagar" class="form-control text-center" >
                            </p>
                          </div>
                          <div class="d-grid gap-2">
                            <button type="submit" name="submit" class="btn btn-primary col-6 mx-auto">Enviar</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <!--Fin Imputs-->

                  <div class="d-grid gap-2 d-md-block text-center">
                    <p>
                      <a href="crear.php"  class="btn btn-primary mt-2">Agregar nuevo Cliente</a>
                    </p>                     
                  </div>
      </div>
  </div>
</div>

<?php include "templates/footer.php";?>

<!--Scripts-->

<script>
  function confirmacion() {
    var respuesta=confirm("¿Esta seguro de eliminar este cliente?");
    if(respuesta==true){
       return true;
    }else {
       return false;
    }
  }
</script>
<script>
    function toggleContenedor1() {
        var contenedor = document.getElementById('cont-abonar');
        if (contenedor.style.display === 'none') {
            contenedor.style.display = 'block';
        } else {
            contenedor.style.display = 'none';
        }
    }
</script>
<script>
    function toggleContenedor2() {
        var contenedor = document.getElementById('cont-anotar');
        if (contenedor.style.display === 'none') {
            contenedor.style.display = 'block';
        } else {
            contenedor.style.display = 'none';
        }
    }
</script>
<script>
    function toggleContenedor3() {
        var contenedor = document.getElementById('cont-pagar');
        if (contenedor.style.display === 'none') {
            contenedor.style.display = 'block';
        } else {
            contenedor.style.display = 'none';
        }
    }
</script>