<?php

// Conexión a la base de datos

$servername = "konten.localhost";
$username = "root";
$password = "";
$dbname = "KONTEN";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión

if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

// Obtener el valor ingresado por el usuario

$pagar = $_POST['pagar'];

// Consultar el saldo actual del cliente
$id =$_GET["id"];
$sql = "SELECT saldo FROM clientes WHERE id = '$id'"; 
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$saldo_actual = $row['saldo'];

// Actualizar el saldo del cliente cancelando el valor ingresado

$nuevo_saldo = $saldo_actual = 0;

$sql_update = "UPDATE clientes SET saldo = $nuevo_saldo WHERE id = '$id'"; 

if ($conn->query($sql_update) === TRUE) {
  ?>
  <?php include "templates/header.php"; ?>

<link rel="stylesheet" href="css/leer.css">
  <div id="contenedor">
    <div id="central">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand">KONTEN</a>
            <div class="text-center text-muted">

            </div>
        </div>
      </nav>
        <div id="login" class="contenedor">
          <div class="titulo_logo">
            <div class="container">
              <div class="row">
                <div class="col-md-12"> 
                  <div class="alert alert-success text-center" role="alert">
                    El valor se ha cancelado correctamente
                  </div> 
                </div>
                <a class="btn btn-secondary" href="leer.php">Regresar</a>                

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
<?php
} else {
  echo "Error al actualizar el saldo: " . $conn->error;
}

$conn->close();

?>
<?php require "templates/header.php"; ?>